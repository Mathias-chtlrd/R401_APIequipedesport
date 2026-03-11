<?php

namespace R301\Modele\Joueur\Commentaire;

use DateTime;
use PDO;
use R301\Modele\DatabaseHandler;

class CommentaireDAO {
    private static ?CommentaireDAO $instance = null;
    private readonly DatabaseHandler $database;

    private function __construct() {
        $this->database = DatabaseHandler::getInstance();
    }

    public static function getInstance(): CommentaireDAO {
        if (self::$instance == null) {
            self::$instance = new CommentaireDAO();
        }
        return self::$instance;
    }

    private function mapToCommentaire(array $dbLine): Commentaire {
    return new Commentaire(
        $dbLine['commentaire_id'],
        $dbLine['contenu'],
        new DateTime($dbLine['date'])
    );
}

    public function selectCommentaireByJoueurId(string $joueurId): array {
        $query = 'SELECT * FROM commentaire WHERE joueur_id = :joueur_id';
        $statement = $this->database->pdo()->prepare($query);
        $statement->execute(array('joueur_id' => $joueurId));
        if ($statement->execute()){
            return array_map(
                function($commentaire) { return $this->mapToCommentaire($commentaire); },
                $statement->fetchAll(PDO::FETCH_ASSOC)
            );
        } else {
            exit();
        }
    }

    public function insertCommentaire(Commentaire $commentaire, string $joueurId): bool {
        $query = 'INSERT INTO commentaire(contenu,date,joueur_id) 
            values (:contenu,:date,:joueur_id)';
        $statement = $this->database->pdo()->prepare($query);
        $statement->bindValue(':joueur_id', $joueurId);
        $statement->bindValue(':contenu', $commentaire->getContenu());
        $statement->bindValue(':date', $commentaire->getDate()->format('Y-m-d H:i'));

        return $statement->execute();
    }

    public function deleteCommentaire(string $commentaireId): bool {
        $query = 'DELETE FROM commentaire WHERE commentaire_id = :commentaireId';
        $statement = $this->database->pdo()->prepare($query);
        $statement->bindValue(':commentaireId', $commentaireId);
        return ($statement->execute());
    }
}