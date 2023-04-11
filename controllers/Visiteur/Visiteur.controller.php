<?php
require_once "./controllers/MainController.controller.php";
require_once "./models/Visiteur/Visiteur.model.php";

class VisiteurController extends MainController
{
    private $visiteurManager;

    public function __construct()
    {
        $this->visiteurManager = new VisiteurManager();
    }

    public function acceuil()
    {
        $utilisateurs = $this->visiteurManager->getUser();

        //echo password_hash("test", PASSWORD_DEFAULT);
        $data_page = [
            "page_description" => "Description de la page d'acceuil",
            "page_title" => "page d'acceuil",
            "utilisateurs" => $utilisateurs,
            //"utilisateur" => $utilisateur,
            "page_javascript" => "main.js",
            "page_css" => "main.css",
            "view" => "views/Visiteur/acceuil.view.php",
            "template" => "views/common/template.php"
        ];
        $this->genererPage($data_page);
    }
    
    public function login()
    {
        $data_page = [
            "page_description" => "Page de connexion",
            "page_title" => "page de connexion",
            "page_css" => "style.css",
            "view" => "views/Visiteur/login.view.php",
            "template" => "views/common/template.php"
        ];
        $this->genererPage($data_page);
    }

    public function creerCompte()
    {
        $data_page = [
            "page_description" => "Page de creation de compte",
            "page_title" => "page creation de compte",
            "page_css" => "style.css",
            "view" => "views/Visiteur/creerCompte.view.php",
            "template" => "views/common/template.php"
        ];
        $this->genererPage($data_page);
    }


    public function pageErreur($msg)
    {
        parent::pageErreur($msg);
    }
}
