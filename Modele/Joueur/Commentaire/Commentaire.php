<?php
namespace R301\Modele\Joueur\Commentaire;

use DateTime;
use R301\Modele\Joueur\Joueur;

class Commentaire {
    private int $commentaireId;
    private readonly string $contenu;
    private readonly DateTime $date;

    public function __construct(int $commentaireId, string $contenu, DateTime $date)
    {
        $this->commentaireId = $commentaireId;
        $this->contenu = $contenu;
        $this->date = $date;
    }

    public function getCommentaireId(): int
    {
        return $this->commentaireId;
    }

    public function getContenu(): string
    {
        return $this->contenu;
    }

    public function getDate(): DateTime
    {
        return $this->date;
    }


}


