<?php

namespace R301\Modele\Utilisateur;

use R301\Modele\DatabaseHandler;

class UtilisateurDAO {
    private static ?UtilisateurDAO $instance = null;
    private readonly DatabaseHandler $database;

    public function __construct() {
        $this->database = DatabaseHandler::getInstance();
    }

    public static function getInstance(): UtilisateurDAO {
        if (self::$instance == null) {
            self::$instance = new UtilisateurDAO();
        }
        return self::$instance;
    }

    public function getUtilisateur(string $username) {
        return new Utilisateur("admin", "admin");
    }


}