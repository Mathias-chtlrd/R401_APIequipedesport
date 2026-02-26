<?php

namespace R301\Modele\Joueur;

use DateTime;
use PDO;
use R301\Modele\DatabaseHandler;

class JoueurDAO {
    private static ?JoueurDAO $instance = null;
    private readonly DatabaseHandler $database;

    private function __construct() {
        $this->database = DatabaseHandler::getInstance();
    }

    public static function getInstance(): JoueurDAO {
        if (self::$instance == null) {
            self::$instance = new JoueurDAO();
        }
        return self::$instance;
    }

    private function mapToJoueur(array $dbLine): Joueur {
        return new Joueur(
            $dbLine['joueur_id'],
            $dbLine['nom'],
            $dbLine['prenom'],
            $dbLine['numero_licence'],
            new DateTime($dbLine['date_naissance']),
            $dbLine['taille'],
            $dbLine['poids'],
            JoueurStatut::fromName($dbLine['statut']),
        );
    }

    public function selectAllJoueurs(): array {
        $query = 'SELECT * FROM joueur';
        $statement=$this->database->pdo()->prepare($query);
        if ($statement->execute()){
            return array_map(
                function($joueur) { return $this->mapToJoueur($joueur); },
                $statement->fetchAll(PDO::FETCH_ASSOC)
            );
        } else {
            exit();
        }
    }

    public function selectJoueursByStatut(JoueurStatut $statut): array {
        $query = 'SELECT * FROM joueur WHERE statut = :statut';
        $statement=$this->database->pdo()->prepare($query);
        $statement->bindValue(':statut', $statut->name);
        if ($statement->execute()){
            return array_map(
                function($joueur) { return $this->mapToJoueur($joueur); },
                $statement->fetchAll(PDO::FETCH_ASSOC)
            );
        } else {
            exit();
        }
    }

    public function selectJoueurById(int $joueurId): Joueur {
        $query = 'SELECT * FROM joueur WHERE joueur_id = :joueur_id';
        $statement=$this->database->pdo()->prepare($query);
        $statement->bindValue(':joueur_id', $joueurId);
        if ($statement->execute()){
             return $this->mapToJoueur($statement->fetch(PDO::FETCH_ASSOC));
        } else {
            exit();
        }
    }

    public function insertJoueur(Joueur $joueurACreer): bool {
        $query = '
            INSERT INTO joueur(numero_licence,nom,prenom,date_naissance,taille,poids,statut)
            VALUES (:numero_licence,:nom,:prenom,:date_naissance,:taille,:poids,:statut)
        ';
        $statement=$this->database->pdo()->prepare($query);
        $statement->bindValue(':numero_licence', $joueurACreer->getNumeroDeLicence());
        $statement->bindValue(':nom', $joueurACreer->getNom());
        $statement->bindValue(':prenom', $joueurACreer->getPrenom());
        $statement->bindValue(':date_naissance', $joueurACreer->getDateDeNaissance()->format('Y-m-d'));
        $statement->bindValue(':taille', $joueurACreer->getTailleEnCm());
        $statement->bindValue(':poids', $joueurACreer->getPoidsEnKg());
        $statement->bindValue(':statut', $joueurACreer->getStatut()->name);

        return $statement->execute();
    }

    public function updateJoueur(Joueur $joueurAModifier): bool {
        $query = 'UPDATE joueur 
                  SET 
                    nom = :nom ,
                    prenom = :prenom,
                    numero_licence = :numero_licence,
                    date_naissance = :date_naissance,
                    taille = :taille,
                    poids = :poids,
                    statut = :statut
                  WHERE joueur_id = :joueur_id';
        $statement=$this->database->pdo()->prepare($query);

        $statement->bindValue(':joueur_id', $joueurAModifier->getJoueurId());
        $statement->bindValue(':numero_licence', $joueurAModifier->getNumeroDeLicence());
        $statement->bindValue(':nom', $joueurAModifier->getNom());
        $statement->bindValue(':prenom', $joueurAModifier->getPrenom());
        $statement->bindValue(':date_naissance', $joueurAModifier->getDateDeNaissance()->format('Y-m-d'));
        $statement->bindValue(':taille', $joueurAModifier->getTailleEnCm());
        $statement->bindValue(':poids', $joueurAModifier->getPoidsEnKg());
        $statement->bindValue(':statut', $joueurAModifier->getStatut()->name);

        return $statement->execute();
    }

    public function supprimerJoueur(string $joueurId) : bool {
        $query = 'DELETE FROM joueur WHERE joueur_id = :joueur_id';
        $statement=$this->database->pdo()->prepare($query);
        $statement->bindValue(':joueur_id', $joueurId);
        return $statement->execute();
    }
}