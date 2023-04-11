<?php

require_once "Model.class.php";

abstract class MainManager extends Model
{

    public function getData()
    {
     $req = $this->getBdd()->prepare("SELECT * FROM user");
     $req->execute();
     $datas = $req->fetchAll(PDO::FETCH_ASSOC);
     $req->closeCursor();
     return $datas;
    }

}