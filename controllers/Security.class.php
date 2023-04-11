<?php

class Security
{
    // c'est un cookie appelé timers pour cacher sa fonction reel
    public const COOKIE_NAME = "timers";

    // function qui protege comme la fonction htmlspecialchars
    public static function secureHTML($chaine){
        return htmlentities($chaine);
    }
    // fuction qui vérifie si l'utilisateur est connecté
    public static function estConnecte()
    {
        return (!empty($_SESSION['profil']));
    }

    // function qui vérifie si c'est un utilisateur
    public static  function estUtilisateur()
    {
        return ($_SESSION['profil']['role'] === "utilisateur");
    }

    public static  function estAdministrateur()
    {
        return ($_SESSION['profil']['role'] === "admin");
    }

    public static function genererCookieConnexion()
    {
        $ticket = session_id().microtime().rand(0,999999);
        $ticket = hash("sha512",$ticket);
        setcookie(self::COOKIE_NAME,$ticket,time()+(60*60));
        $_SESSION['profil'][self::COOKIE_NAME] = $ticket;
    }

    public static function checkCookieConnexion()
    {
        return $_COOKIE[self::COOKIE_NAME] === $_SESSION['profil'][self::COOKIE_NAME];
    }

}