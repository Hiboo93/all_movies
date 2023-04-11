<?php
class ToolBox 
{
    public const COULEUR_ROUGE = 'alert-danger';
    public const COULEUR_ORANGE = 'alert-warning';
    public const COULEUR_VERTE = 'alert-success';
    
    public static function ajouterMessageAlerte($message,$type)
    {
        $_SESSION['alert'][] = [
            "message" => $message,
            "type" => $type
        ];
    }

    public static function sendMail($destinataire, $sujet, $message)
    {
        $headers = "FROM: ibagayo@gmail.com";
        if(mail($destinataire,$sujet,$message,$headers)){
            self::ajouterMessageAlerte("Mail envoyé",ToolBox::COULEUR_VERTE);
        } else {
            self::ajouterMessageAlerte("Envoi Mail échoué",ToolBox::COULEUR_ROUGE);
        }
    }

}