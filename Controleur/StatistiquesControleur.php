<?php

namespace R301\Controleur;

use DateTime;
use R301\Modele\Joueur\Commentaire\Commentaire;
use R301\Modele\Joueur\Commentaire\CommentaireDAO;
use R301\Modele\Joueur\Joueur;
use R301\Modele\Joueur\JoueurDAO;
use R301\Modele\Joueur\JoueurStatut;
use R301\Modele\Statistiques\StatistiquesEquipe;
use R301\Modele\Statistiques\StatistiquesJoueurs;

class StatistiquesControleur {
    private static ?StatistiquesControleur $instance = null;
    private readonly RencontreControleur $rencontres;
    private readonly ParticipationControleur $participations;

    private function __construct() {
        $this->rencontres = RencontreControleur::getInstance();
        $this->participations = ParticipationControleur::getInstance();
    }

    public static function getInstance(): StatistiquesControleur {
        if (self::$instance == null) {
            self::$instance = new StatistiquesControleur();
        }
        return self::$instance;
    }

    public function getStatistiquesEquipe() : StatistiquesEquipe {
        return new StatistiquesEquipe($this->rencontres->listerToutesLesRencontres());
    }

    public function getStatistiquesJoueurs() : StatistiquesJoueurs {
        return new StatistiquesJoueurs($this->participations->listerToutesLesParticipations(), $this->rencontres->listerToutesLesRencontres());
    }
}