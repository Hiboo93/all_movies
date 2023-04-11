<?php
require_once "./models/MainManager.model.php";

class VisiteurManager extends MainManager
{
    public function getUser()
    {
        $req = $this->getBdd()->prepare("SELECT * FROM user");
        $req->execute();
        $datas = $req->fetchAll(PDO::FETCH_ASSOC);
        $req->closeCursor();
        return $datas;
    }

    // public function getUserOne($login)
    // {
    //     $pdo = $this->getBdd();
    //     $req = $pdo->prepare("SELECT * FROM user WHERE login = 'test'");
    //     $req->execute();
    //     $datas = $req->fetch(PDO::FETCH_ASSOC);
    //     $req->closeCursor();
    //     return $datas;
    // }
}