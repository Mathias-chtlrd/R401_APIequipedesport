<?php

namespace R301\Modele\Rencontre;

use DateTime;
use PDO;
use R301\Modele\DatabaseHandler;

class RencontreDAO {
    private static ?RencontreDAO $instance = null;
    private readonly DatabaseHandler $database;

    private function __construct() {
        $this->database = DatabaseHandler::getInstance();
    }

    public static function getInstance(): RencontreDAO {
        if (self::$instance == null) {
            self::$instance = new RencontreDAO();
        }
        return self::$instance;
    }

    private function mapToRencontre(array $dbLine): Rencontre {
        return new Rencontre(
            new DateTime($dbLine['date_heure']),
            $dbLine['equipe_adverse'],
            $dbLine['adresse'],
            $dbLine['lieu'] ? RencontreLieu::fromName($dbLine['lieu']) : null,
            $dbLine['resultat'] ? RencontreResultat::fromName($dbLine['resultat']) : null,
            $dbLine['rencontre_id']
        );
    }

    public function selectAllRencontres(): array {
        $query = 'SELECT * FROM rencontre';
        $statement=$this->database->pdo()->prepare($query);
        if ($statement->execute()){
            return array_map(
                function($rencontre) { return $this->mapToRencontre($rencontre); },
                $statement->fetchAll(PDO::FETCH_ASSOC)
            );
        } else {
            exit();
        }
    }

    public function selectRencontreById(string $rencontreId): Rencontre
    {
        $query = 'SELECT * FROM rencontre WHERE rencontre_id = :rencontreId';
        $statement=$this->database->pdo()->prepare($query);
        $statement->bindValue(':rencontreId', $rencontreId);
        if ($statement->execute()){
             return $this->mapToRencontre($statement->fetch(PDO::FETCH_ASSOC));
        } else {
            exit();
        }
    }

    public function insertRencontre(Rencontre $rencontreACreer): bool {
        $query = '
            INSERT INTO rencontre(date_heure, equipe_adverse, adresse, lieu, resultat)
            VALUES (:date_heure,:equipe_adverse,:adresse,:lieu,:resultat)
        ';
        $statement=$this->database->pdo()->prepare($query);
        $statement->bindValue(':date_heure', $rencontreACreer->getDateEtHeure()->format('Y-m-d H:i:s'));
        $statement->bindValue(':equipe_adverse', $rencontreACreer->getEquipeAdverse());
        $statement->bindValue(':adresse', $rencontreACreer->getAdresse());
        $statement->bindValue(':lieu', $rencontreACreer->getLieu()->name);
        $statement->bindValue(':resultat', $rencontreACreer->getResultat()->name);

        return $statement->execute();
    }

    public function updateRencontre(Rencontre $rencontreAModifier): bool {
        $query = 'UPDATE rencontre 
                  SET 
                      date_heure = :date_heure,
                      equipe_adverse = :equipe_adverse,
                      adresse = :adresse,
                      lieu = :lieu
                  WHERE rencontre_id = :rencontreId';
        $statement=$this->database->pdo()->prepare($query);
        $statement->bindValue(':rencontreId', $rencontreAModifier->getRencontreId());
        $statement->bindValue(':date_heure', $rencontreAModifier->getDateEtHeure()->format('Y-m-d H:i:s'));
        $statement->bindValue(':equipe_adverse', $rencontreAModifier->getEquipeAdverse());
        $statement->bindValue(':adresse', $rencontreAModifier->getAdresse());
        $statement->bindValue(':lieu', $rencontreAModifier->getLieu()->name);
        return $statement->execute();
    }

    public function enregistrerResultat(Rencontre $rencontreAModifier): bool {
        $query = 'UPDATE rencontre 
                  SET 
                      resultat = :resultat
                  WHERE rencontre_id = :rencontreId';
        $statement=$this->database->pdo()->prepare($query);
        $statement->bindValue(':rencontreId', $rencontreAModifier->getRencontreId());
        $statement->bindValue(':resultat', $rencontreAModifier->getResultat()->name);
        return $statement->execute();
    }

    public function supprimerRencontre(int $rencontreId) : bool {
        $query = 'DELETE FROM rencontre WHERE rencontre_id = :rencontreId';
        $statement=$this->database->pdo()->prepare($query);
        $statement->bindValue(':rencontreId', $rencontreId);
        return $statement->execute();
    }
}