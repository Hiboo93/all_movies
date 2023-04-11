<?php
require_once "./models/MainManager.model.php";

class AdministrateurManager extends MainManager
{
    private function getPasswordUser($login)
    {
        $req = "SELECT password FROM user WHERE login = :login ";
        $statement = $this->getBdd()->prepare($req);
        $statement->bindValue(":login", $login,PDO::PARAM_STR);
        $statement->execute();
        $resultat = $statement->fetch(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        return $resultat['password'];
    }

    public function getUtilisateurs()
    {
        $req = "SELECT * FROM user ";
        $statement = $this->getBdd()->query($req);
        $statement->execute();
        $datas = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        return $datas;
    }

   public function isCombinaisonValide($login, $password)
   {
    $passwordBD = $this->getPasswordUser($login);
    //echo $passwordBD;
    return password_verify($password, $passwordBD);
   }

   public function isCompteActive($login){
    $req = "SELECT est_valide, role FROM user WHERE login = :login AND role = 'admin'";
    $statement = $this->getBdd()->prepare($req);
    $statement->bindValue(":login", $login,PDO::PARAM_STR);
    $statement->execute();
    $resultat = $statement->fetch(PDO::FETCH_ASSOC);
    $statement->closeCursor();
    return ((int)$resultat['est_valide'] === 1) ? true : false;
    return false;
   }

   public function getUserInformation($login)
   {
    $req = "SELECT * FROM user WHERE login = :login";
    $statement = $this->getBdd()->prepare($req);
    $statement->bindValue(":login",$login,PDO::PARAM_STR);
    $statement->execute();
    $resultat = $statement->fetch(PDO::FETCH_ASSOC);
    $statement->closeCursor();
    return $resultat;
   }

   //function qui vérifie si le login n'est pas utilisé en base de donnée
   public function checkLogin($login)
   {
    $utilisateur = $this->getUserInformation($login);
    return empty($utilisateur);
   }
   
   public function creatCompteInBdd($login,$passwordCrypte,$mail,$clef,$image,$role)
   {
        $req = "INSERT INTO user (login, password, mail, est_valide, role, clef, image)
        VALUES (:login, :password, :mail, 0, :role, :clef, :image)";
        $statement = $this->getBdd()->prepare($req);
        $statement->bindValue(":login",$login,PDO::PARAM_STR);
        $statement->bindValue(":password",$passwordCrypte,PDO::PARAM_STR);
        $statement->bindValue(":mail",$mail,PDO::PARAM_STR);
        $statement->bindValue(":clef",$clef,PDO::PARAM_INT);
        $statement->bindValue(":image",$image,PDO::PARAM_STR);
        $statement->bindValue(":role",$role,PDO::PARAM_STR);
        $statement->execute();
        $estModifier = ($statement->rowCount() > 0);
        $statement->closeCursor();
        return $estModifier;
   }

   public function bddValidationCompteMail($login,$clef)
   {
        $req = "UPDATE user SET est_valide = 1 WHERE login = :login and clef = :clef";
        $statement = $this->getBdd()->prepare($req);
        $statement->bindValue(":login",$login,PDO::PARAM_STR);
        $statement->bindValue(":clef",$clef,PDO::PARAM_INT);
        $statement->execute();
        $estModifier = ($statement->rowCount() > 0);
        $statement->closeCursor();
        return $estModifier;
   }

   public function updateMail($login,$mail)
   {
        $req = "UPDATE user SET mail = :mail WHERE login = :login";
        $statement = $this->getBdd()->prepare($req);
        $statement->bindValue(":login",$login,PDO::PARAM_STR);
        $statement->bindValue(":mail",$mail,PDO::PARAM_STR);
        $statement->execute();
        $estModifier = ($statement->rowCount() > 0);
        $statement->closeCursor();
        return $estModifier;
   }

   public function updatePassword($login,$password)
   {
     $req = "UPDATE user SET password = :password WHERE login = :login";
        $statement = $this->getBdd()->prepare($req);
        $statement->bindValue(":login",$login,PDO::PARAM_STR);
        $statement->bindValue(":password",$password,PDO::PARAM_STR);
        $statement->execute();
        $estModifier = ($statement->rowCount() > 0);
        $statement->closeCursor();
        return $estModifier;
   }

   public function bdSuppressionCompte($login)
   {
     $req = "DELETE FROM user WHERE login = :login";
     $statement = $this->getBdd()->prepare($req);
        $statement->bindValue(":login",$login,PDO::PARAM_STR);
        $statement->execute();
        $estModifier = ($statement->rowCount() > 0);
        $statement->closeCursor();
        return $estModifier;
   }

   public function bdSuppressionCompteUser($login)
   {
     $req = "DELETE FROM user WHERE login = :login";
     $statement = $this->getBdd()->prepare($req);
        $statement->bindValue(":login",$login,PDO::PARAM_STR);
        $statement->execute();
        $estModifier = ($statement->rowCount() > 0);
        $statement->closeCursor();
        return $estModifier;
   }

}