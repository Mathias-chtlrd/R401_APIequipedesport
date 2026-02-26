<?php

namespace R401_APIequipedesport\Modele; 

use Exception;
use PDO;

class DatabaseHandler {
    private static ?DatabaseHandler $instance = null;
    private readonly PDO $linkpdo;
    private readonly string $server;
    private readonly string $db;
    private readonly string $login;
    private readonly string $mdp;
    
//database connexion for BD_equipe with admin account
    private function __construct(){
        try{
            $this->server = "mysql-mathmams.alwaysdata.net";
            $this->db = "mathmams_bd_r401";
            $this->login = "mathmams_admin";
            $this->mdp = "rootpwd";
            $this->linkpdo=new PDO("mysql:host=".$this->server.";dbname=".$this->db,$this->login,$this->mdp);
        }catch(Exception $e){
            die("Erreur : ".$e->getMessage());
        }
    }

    public static function getInstance(): DatabaseHandler
    {
        if (self::$instance == null) {
            self::$instance = new DatabaseHandler();
        }
        return self::$instance;
    }

    public function pdo(): PDO {
        return $this->linkpdo;
    }
}
