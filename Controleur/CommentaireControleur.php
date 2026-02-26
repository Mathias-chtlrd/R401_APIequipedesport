<?php

namespace R301\Controleur;

use DateTime;
use R301\Modele\Joueur\Commentaire\Commentaire;
use R301\Modele\Joueur\Commentaire\CommentaireDAO;
use R301\Modele\Joueur\Joueur;
use R301\Modele\Joueur\JoueurDAO;
use R301\Modele\Joueur\JoueurStatut;

class CommentaireControleur {
    private static ?CommentaireControleur $instance = null;
    private readonly CommentaireDAO $commentaires;

    private function __construct() {
        $this->commentaires = CommentaireDAO::getInstance();
    }

    public static function getInstance(): CommentaireControleur {
        if (self::$instance == null) {
            self::$instance = new CommentaireControleur();
        }
        return self::$instance;
    }

    public function ajouterCommentaire(
        string $contenu,
        string $joueurId
    ) : bool {

        $commentaireACreer = new Commentaire(
            0,
            $contenu,
            new DateTime()
        );

        return $this->commentaires->insertCommentaire($commentaireACreer, $joueurId);
    }

    public function listerLesCommentairesDuJoueur(Joueur $joueur) : array {
        return $this->commentaires->selectCommentaireByJoueurId($joueur->getJoueurId());
    }

    public function supprimerCommentaire(string $commentaireId) : bool {
        return $this->commentaires->deleteCommentaire($commentaireId);
    }
}