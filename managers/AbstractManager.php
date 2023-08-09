<?php

class AbstractManager
{
    protected $db;

    public function __construct()
    {

        $connexion = "mysql:host=db.3wa.io;port=3306;charset=utf8;dbname=marierichir_farming-companion";
        $this->db = new PDO(
            $connexion,
            "marierichir",
            "a616eefc0b8af8e5fb785ae6b42c19f1"
        );
    }
}

?>