<?php
session_start();

define("URL", str_replace("index.php","",(isset($_SERVER['HTTPS'])? "https" : "http")."://".$_SERVER['HTTP_HOST'].$_SERVER["PHP_SELF"]));
require_once "./controllers/Toolbox.class.php";
require_once "./controllers/Visiteur/Visiteur.controller.php";
require_once "./controllers/Utilisateur/Utilisateur.controller.php";
require_once "./controllers/Administrateur/Administrateur.controller.php";
require_once "./controllers/Security.class.php";
$visiteurController = new VisiteurController();
$utilisateurController = new UtilisateurController();
$administrateurController = new administrateurController();

try {
    if(empty($_GET['page'])){
        $page = "d'acceuil";
    } else {
        $url = explode("/", filter_var($_GET['page'], FILTER_SANITIZE_URL));
        $page = $url[0];
    }
    
    switch ($page) {
        case 'acceuil':
            $visiteurController->acceuil();
            break;

            //login est aussi la page d'acceuil
        case 'login':
            $visiteurController->login();
            break;

        case "profilAdmin":
            $administrateurController->profilAdministrateur();
        break;

        case 'login_administrateur':
            $administrateurController->loginAdministrateur();
            break;

        case 'validation_login':
            if(!empty($_POST['login']) && !empty($_POST['password'])){
                $login = Security::secureHTML($_POST['login']);
                $password = Security::secureHTML($_POST['password']);
                $utilisateurController->validation_login($login,$password);
            } else {
                ToolBox::ajouterMessageAlerte("login ou Mot de passe non renseigné", ToolBox::COULEUR_ROUGE);
                header('Location: '.URL."Login");
            }
            break;

        case 'validation_login_administrateur':
            if(!empty($_POST['login']) && !empty($_POST['password'])){
                $login = Security::secureHTML($_POST['login']);
                $password = Security::secureHTML($_POST['password']);
                $administrateurController->validation_login($login,$password);
            } else {
                ToolBox::ajouterMessageAlerte("login ou Mot de passe non renseigné", ToolBox::COULEUR_ROUGE);
                header('Location: '.URL."Login");
            }
            break;

        case 'creerCompte':
            $visiteurController->creerCompte();
            break;

        case 'validation_creerCompte':
            if(!empty($_POST['login']) && !empty($_POST['password']) && !empty($_POST['mail'])){
                $login = Security::secureHTML($_POST['login']);
                $password = Security::secureHTML($_POST['password']);
                $mail = Security::secureHTML($_POST['mail']);
                $utilisateurController->validation_creerCompte($login,$password,$mail);
            } else {
                ToolBox::ajouterMessageAlerte("Les 3 informations sont obligatoires !",ToolBox::COULEUR_ROUGE);
                header("Location: ".URL."creerCompte");
            }
            break;


        case 'renvoyerMailValidation':
            $utilisateurController->renvoyerMailValidation($url[1]);
            break;

        case 'validationMail':
            $utilisateurController->validationCompteMail($url[1],$url[2]);
            break;

        case 'compte':
            if(!Security::estConnecte()){
                ToolBox::ajouterMessageAlerte("Veuillez vous connecter !",ToolBox::COULEUR_ROUGE);
                header("Location: ".URL."login");
            }elseif(!Security::checkCookieConnexion()) {
                ToolBox::ajouterMessageAlerte("Veuillez vous reconnecter !",ToolBox::COULEUR_ROUGE);
                session_unset("profil");
                header("Location: ".URL."login");
            }else {
                Security::genererCookieConnexion();//regénération du cookie
                switch($url[1]){
                    case "profil":
                        $utilisateurController->profil();
                    break;
                    
                    case "deconnexion":
                        $utilisateurController->deconnexion();
                    break;
                    case "deconnexion_administrateur":
                        $administrateurController->deconnexion();
                    break;

                    case 'validation_modificationMail':
                        $utilisateurController->validation_ModificationMail(Security::secureHTML($_POST['mail']));
                        break;
                    case 'validation_modificationMail_administrateur':
                        $administrateurController->validation_ModificationMail(Security::secureHTML($_POST['mail']));
                        break;

                    case 'modificationPassword':
                        $utilisateurController->modificationPassword();
                        break;
                    case 'modificationPassword_administrateur':
                        $administrateurController->modificationPassword();
                        break;

                    case 'validation_modificationPassword':
                        if(!empty($_POST['ancienpassword']) && !empty($_POST['nouveaupassword']) && !empty($_POST['confirmpassword'])){
                            $ancienPassword = Security::secureHTML($_POST['ancienpassword']);
                            $nouveauPassword = Security::secureHTML($_POST['nouveaupassword']);
                            $confirmPassword = Security::secureHTML($_POST['confirmpassword']);
                            $utilisateurController->Validation_ModificationPassword($ancienPassword,$nouveauPassword,$confirmPassword);
                        } else {
                            ToolBox::ajouterMessageAlerte("Vous n'avez pas renseigné toutes les informations",ToolBox::COULEUR_ROUGE);
                            header("Location: ".URL."compte/modificationPassword");
                        }
                        break;
                    case 'validation_modificationPassword_administrateur':
                        if(!empty($_POST['ancienpassword']) && !empty($_POST['nouveaupassword']) && !empty($_POST['confirmpassword'])){
                            $ancienPassword = Security::secureHTML($_POST['ancienpassword']);
                            $nouveauPassword = Security::secureHTML($_POST['nouveaupassword']);
                            $confirmPassword = Security::secureHTML($_POST['confirmpassword']);
                            $administrateurController->Validation_ModificationPassword($ancienPassword,$nouveauPassword,$confirmPassword);
                        } else {
                            ToolBox::ajouterMessageAlerte("Vous n'avez pas renseigné toutes les informations",ToolBox::COULEUR_ROUGE);
                            header("Location: ".URL."compte/modificationPassword_administrateur");
                        }
                        break;

                        case 'suppressionCompte':
                            $utilisateurController->suppressionCompte();
                            break;
                        case 'suppressionCompte_administrateur':
                            $administrateurController->suppressionCompte();
                            break;

                        case 'info_movies':
                            $utilisateurController->infoMovies();
                            echo "HELLO";
                            break;

                    default : throw new Exception("La page n'existe pas");
                }
            }
        break;

        default : throw new Exception("La page n'existe pas");
    }
} catch (Exception $e) {
            $visiteurController->pageErreur($e->getMessage());
}




