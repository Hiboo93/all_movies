<?php
require_once "./controllers/MainController.controller.php";
require_once "./models/Utilisateur/Utilisateur.model.php";
require_once "./controllers/Toolbox.class.php";

class UtilisateurController extends MainController
{
    private $utilisateurManager;

    public function __construct()
    {
        $this->utilisateurManager = new utilisateurManager();
    }

    public function validation_login($login, $password)
    {
        if($this->utilisateurManager->isCombinaisonValide($login,$password)){
            if($this->utilisateurManager->isCompteActive($login)){
                ToolBox::ajouterMessageAlerte("Bon retour sur le site  ".$login."!", ToolBox::COULEUR_VERTE);
                //Variable de session
                $_SESSION['profil'] = [
                    "login" => $login
                ];
                Security::genererCookieConnexion();

                header("location: ".URL."compte/profil");
            } else {
                $msg = "Le compte ".$login. " n'a pas été activé par mail.  ";
                $msg .= "<a href='renvoyerMailValidation/".$login."'>Cliquer ici : Renvoyez le mail de validation</a>";
                ToolBox::ajouterMessageAlerte($msg, ToolBox::COULEUR_ROUGE);
                header("Location: ".URL."login");
            }
        } else {
            ToolBox::ajouterMessageAlerte("Combinaison Login / Mot de passe non valide", ToolBox::COULEUR_ROUGE);
            header("Location: ".URL."login");
        }
    }

    public function profil()
    {
        $datas = $this->utilisateurManager->getUserInformation($_SESSION['profil']['login']);
        $_SESSION['profil']['role'] = $datas['role'];

        $data_page = [
            "page_description" => "Page de profil",
            "page_title" => "Page profil",
            "utilisateur" => $datas,
            "page_javascript" => "script.js",
            "page_javascript" => "main.js",
            //"page_css" => "style.css",
            "page_css" => "main.css",
            //"page_css" => ["main.css","style.css"],
            "view" => "views/Utilisateur/utilisateur.view.php",
            "template" => "views/common/template.php"
        ];
        $this->genererPage($data_page);
    }

    public function deconnexion()
    {
        ToolBox::ajouterMessageAlerte("La déconnexion a bien été réalisé", ToolBox::COULEUR_VERTE);
        unset($_SESSION['profil']);
        setcookie(Security::COOKIE_NAME, "",time() - 3600);
        header("Location: ".URL."acceuil");
    }

    public function validation_creerCompte($login,$password,$mail)
    {
        //checkLogin vérifie la disponibilité du login  s'il n'est pas en base de données
        if($this->utilisateurManager->checkLogin($login)){
            $passwordCrypte = password_hash($password,PASSWORD_DEFAULT);
            $clef = rand(0,9999);
            if($this->utilisateurManager->creatCompteInBdd($login,$passwordCrypte,$mail,$clef,"profils/avatar.jpg",'utilisateur')){
                $this->sendMailValidation($login,$mail,$clef);
                ToolBox::ajouterMessageAlerte("Le compte a été créer, un Mail de validation vous a été envoyé", ToolBox::COULEUR_VERTE);
                header("Location: ".URL."login");
            } else {
                ToolBox::ajouterMessageAlerte("Erreur lors de la création du compte, recommencer",ToolBox::COULEUR_ROUGE);
                header("Location: ".URL."creerCompte");
            }
        } else {
            ToolBox::ajouterMessageAlerte("le login est déjà utilisé", ToolBox::COULEUR_ROUGE);
            header("Location: ".URL."creerCompte");
        }
    }

    // function qui envoi un email qui contient un lien pour valider son compte d'inscription
    private function sendMailValidation($login,$mail,$clef)
    {
        $urlVerification = URL."validationMail/".$login."/".$clef;
        $sujet = "Création du compte sur le site xxx";
        $message = "Pour valider votre compte veuillez cliquer sur le lien suivant".$urlVerification;
        ToolBox::sendMail($mail,$sujet,$message);
    }

    //function qui renvoie le mail de validation
    public function renvoyerMailValidation($login)
    {
        $utilisateur = $this->utilisateurManager->getUserInformation($login);
        $this->sendMailValidation($login,$utilisateur['mail'],$utilisateur['clef']);
        header("Location: ".URL."login");
    }

    public function validationCompteMail($login,$clef)
    {
        if($this->utilisateurManager->bddValidationCompteMail($login,$clef)){
            ToolBox::ajouterMessageAlerte("Le compte a été activé !", ToolBox::COULEUR_VERTE);
            header('Location: '.URL.'login');
        } else {
            ToolBox::ajouterMessageAlerte("Le compte n'a pas été activé !", ToolBox::COULEUR_ROUGE);
            header('Location: '.URL.'creerCompte');
        }
    }

    public function validation_ModificationMail($mail)
    {
        if($this->utilisateurManager->updateMail($_SESSION['profil']['login'],$mail)){
            ToolBox::ajouterMessageAlerte("Votre compte profil a bien été mise à jour", ToolBox::COULEUR_VERTE);
        } else {
            ToolBox::ajouterMessageAlerte("aucune modification effectuée",ToolBox::COULEUR_ROUGE);
        }
        header('Location: '.URL.'compte/profil');
    }

    public function modificationPassword()
    {
        $data_page = [
            "page_description" => "Page modification du password",
            "page_title" => "Page modification password",
            "page_javascript" => "script.js",
            //"page_javascript" => "main.js",
            //"page_css" => "style.css",
            "page_css" => "main.css",
            //"page_css" => ["main.css","style.css"],
            "view" => "views/Utilisateur/modificationPassword.view.php",
            "template" => "views/common/template.php"
        ];
        $this->genererPage($data_page);
    }

    public function Validation_ModificationPassword($ancienPassword,$nouveauPassword,$confirmPassword)
    {
        if($nouveauPassword === $confirmPassword){
            if($this->utilisateurManager->isCombinaisonValide($_SESSION['profil']['login'],$ancienPassword)){
                $passwordCrypte = password_hash($nouveauPassword,PASSWORD_DEFAULT);
                if($this->utilisateurManager->updatePassword($_SESSION['profil']['login'],$passwordCrypte)){
                    ToolBox::ajouterMessageAlerte("Mot de passe mise à jour",ToolBox::COULEUR_VERTE);
                    header("Location: ".URL."compte/profil");
                } else {
                    ToolBox::ajouterMessageAlerte("Modification échouée",ToolBox::COULEUR_VERTE);
                    header("Location: ".URL."compte/modificationPassword");
                }
            } else {
                ToolBox::ajouterMessageAlerte("La combinaison login / ancien mot de passe ne correspondent pas",ToolBox::COULEUR_ROUGE);
                header("Location: ".URL."compte/modificationPassword");
            }
        } else {
            ToolBox::ajouterMessageAlerte("Les Mots de passe ne correspondent pas",ToolBox::COULEUR_ROUGE);
            header("Location: ".URL."compte/modificationPassword");
        }
    }

    public function suppressionCompte()
    {
        if($this->utilisateurManager->bdSuppressionCompte($_SESSION['profil']['login'])){
            ToolBox::ajouterMessageAlerte("La suppression du compte est effectuée",ToolBox::COULEUR_VERTE);
            $this->deconnexion();
        } else {
            ToolBox::ajouterMessageAlerte("La suppresion n'a pas été effectuée. Contacté l'administrateur",ToolBox::COULEUR_ROUGE);
            header("Location:".URL."compte/profil");
        }
    }

    public function infoMovies(){
        $data_page = [
            "page_description" => "Page Info film",
            "page_title" => "information film",
            "page_javascript" => "script.js",
            //"page_javascript" => "main.js",
            //"page_css" => "style.css",
            "page_css" => "main.css",
            //"page_css" => ["main.css","style.css"],
            "view" => "views/Utilisateur/movie.info.view.php",
            "template" => "views/common/template.php"
        ];
        $this->genererPage($data_page);
    }


    public function pageErreur($msg)
    {
        parent::pageErreur($msg);
    }
}