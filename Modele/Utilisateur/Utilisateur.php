<?php

namespace R301\modele\utilisateur;

use Cassandra\Date;
use R301\Modele\Joueur\JoueurStatut;

class Utilisateur {
    private readonly string $login;
    private readonly string $motDePasse;

    public function __construct(
        string $login,
        string $motDePasse
    ) {
        $this->login = $login;
        $this->motDePasse = $motDePasse;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function getMotDePasse(): string
    {
        return $this->motDePasse;
    }
}

