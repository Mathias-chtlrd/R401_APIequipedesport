<?php

namespace R301\Controleur;

use DateTime;
use R301\Modele\Joueur\Joueur;
use R301\Modele\Joueur\JoueurDAO;
use R301\Modele\Joueur\JoueurStatut;

class JoueurControleur {
    private static ?JoueurControleur $instance = null;
    private readonly JoueurDAO $joueurs;
    private readonly ParticipationControleur $participationControleur;

    private function __construct() {
        $this->joueurs = JoueurDAO::getInstance();
        $this->participationControleur = ParticipationControleur::getInstance();
    }

    public static function getInstance(): JoueurControleur {
        if (self::$instance == null) {
            self::$instance = new JoueurControleur();
        }
        return self::$instance;
    }

    public function ajouterJoueur(
        string $nom,
        string $prenom,
        string $numeroDeLicence,
        DateTime $dateDeNaissance,
        int $tailleEnCm,
        int $poidsEnKg,
        string $statut
    ) : bool {
        $joueurACreer = new Joueur(
            0,
            $nom,
            $prenom,
            $numeroDeLicence,
            $dateDeNaissance,
            $tailleEnCm,
            $poidsEnKg,
            JoueurStatut::fromName($statut)
        );

        return $this->joueurs->insertJoueur($joueurACreer);
    }

    public function getJoueurById(int $joueurId) : Joueur {
        return $this->joueurs->selectJoueurById($joueurId);
    }

    public function listerLesJoueursSelectionnablesPourUnMatch(int $rencontreId) : array {
        $joueursActifs = $this->joueurs->selectJoueursByStatut(JoueurStatut::ACTIF);
        $joueursSelectionnables = [];

        foreach ($joueursActifs as $joueur) {
            if (!$this->participationControleur->lejoueurEstDejaSurLaFeuilleDeMatch($rencontreId, $joueur->getJoueurId())) {
                $joueursSelectionnables[] = $joueur;
            }
        }

        return $joueursSelectionnables;
    }

    public function listerTousLesJoueurs() : array {
        return $this->joueurs->selectAllJoueurs();
    }

    public function modifierJoueur(
        int $joueurId,
        string $nom,
        string $prenom,
        string $numeroDeLicence,
        DateTime $dateDeNaissance,
        int $tailleEnCm,
        int $poidsEnKg,
        string $statut
    ) : bool {
        $joueurAModifier = $this->joueurs->selectJoueurById($joueurId);

        $joueurAModifier->setNom($nom);
        $joueurAModifier->setPrenom($prenom);
        $joueurAModifier->setNumeroDeLicence($numeroDeLicence);
        $joueurAModifier->setDateDeNaissance($dateDeNaissance);
        $joueurAModifier->setTailleEnCm($tailleEnCm);
        $joueurAModifier->setPoidsEnKg($poidsEnKg);
        $joueurAModifier->setStatut(JoueurStatut::fromName($statut));

        return $this->joueurs->updateJoueur($joueurAModifier);
    }

    public function rechercherLesJoueurs(string $recherche, string $statut) : array {
        $tousLesjoueurs = $this->joueurs->selectAllJoueurs();
        $joueursTrouves = [];

        foreach ($tousLesjoueurs as $joueur) {
            $conserverDansLaListe = true;

            if ($recherche !== "") {
                $conserverDansLaListe = $joueur->nomOuPrenomContient($recherche);
            }

            if ($conserverDansLaListe && $statut !== "") {
                $conserverDansLaListe = $joueur->getStatut() == JoueurStatut::fromName($statut);
            }

            if ($conserverDansLaListe) {
                $joueursTrouves[] = $joueur;
            }
        }

        return $joueursTrouves;
    }

    public function supprimerJoueur(int $joueurId) : bool {
        return $this->joueurs->supprimerJoueur($joueurId);
}
}