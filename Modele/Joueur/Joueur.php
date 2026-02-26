<?php

namespace R301\Modele\Joueur;

use DateTime;

class Joueur {
    private int $joueurId;
    private string $nom;
    private string $prenom;
    private string $numeroDeLicence;
    private DateTime $dateDeNaissance;
    private int $tailleEnCm;
    private int $poidsEnKg;
    private ?JoueurStatut $statut;

    public function __construct(
        int $joueurId,
        string $nom,
        string $prenom,
        string $numeroDeLicence,
        DateTime $dateDeNaissance,
        int $tailleEnCm,
        int $poidsEnKg,
        ?JoueurStatut $statut
    ) {
        $this->joueurId = $joueurId;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->numeroDeLicence = $numeroDeLicence;
        $this->dateDeNaissance = $dateDeNaissance;
        $this->tailleEnCm = $tailleEnCm;
        $this->poidsEnKg = $poidsEnKg;
        $this->statut = $statut;
    }

    public function nomOuPrenomContient(string $recherche) : bool {
        return str_contains(strtolower($this->nom), strtolower($recherche))
            || str_contains(strtolower($this->prenom), strtolower($recherche));
    }

    public function toString() : string {
        $selectableString = "";
        $selectableString .= $this->getNumeroDeLicence() . ' : ' . $this->nom . ' ' . $this->prenom;

        if ($this->statut !== JoueurStatut::ACTIF) {
            $selectableString .= ' (' . $this->statut->name . ')';
        }
        return $selectableString;
    }

    public function getJoueurId(): int
    {
        return $this->joueurId;
    }

    public function setJoueurId(int $joueurId): void
    {
        $this->joueurId = $joueurId;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getPrenom() {
        return $this->prenom;
    }

    public function getNumeroDeLicence() {
        return $this->numeroDeLicence;
    }

    public function getDateDeNaissance() : DateTime {
        return $this->dateDeNaissance;
    }

    public function getTailleEnCm() {
        return $this->tailleEnCm;
    }

    public function getPoidsEnKg() {
        return $this->poidsEnKg;
    }

    public function getStatut() {
        return $this->statut;
    }

    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    public function setPrenom(string $prenom): void
    {
        $this->prenom = $prenom;
    }

    public function setNumeroDeLicence(string $numeroDeLicence): void
    {
        $this->numeroDeLicence = $numeroDeLicence;
    }

    public function setDateDeNaissance(DateTime $dateDeNaissance): void
    {
        $this->dateDeNaissance = $dateDeNaissance;
    }

    public function setTailleEnCm(int $tailleEnCm): void
    {
        $this->tailleEnCm = $tailleEnCm;
    }

    public function setPoidsEnKg(int $poidsEnKg): void
    {
        $this->poidsEnKg = $poidsEnKg;
    }

    public function setStatut(?JoueurStatut $statut): void
    {
        $this->statut = $statut;
    }
}

