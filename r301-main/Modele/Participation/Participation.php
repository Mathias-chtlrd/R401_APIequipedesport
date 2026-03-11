<?php

namespace R301\Modele\Participation;

use R301\Modele\Joueur\Joueur;
use R301\Modele\Rencontre\Rencontre;

class Participation {
    private int $participationId;
    private Joueur $participant;
    private readonly Rencontre $rencontre;
    private TitulaireOuRemplacant $titulaireOuRemplacant;
    private ?Performance $performance;
    private Poste $poste;

    public function __construct(
        int $participationId,
        Joueur $participant,
        Rencontre $rencontre,
        TitulaireOuRemplacant $titulaireOuRemplacant,
        ?Performance $performance,
        Poste $poste
    ) {
        $this->participationId = $participationId;
        $this->participant = $participant;
        $this->rencontre = $rencontre;
        $this->titulaireOuRemplacant = $titulaireOuRemplacant;
        $this->performance = $performance;
        $this->poste = $poste;
    }

    public function getParticipant(): Joueur
    {
        return $this->participant;
    }

    public function setParticipant(Joueur $participant): void
    {
        $this->participant = $participant;
    }

    public function getRencontre(): Rencontre
    {
        return $this->rencontre;
    }

    public function getParticipationId(): int
    {
        return $this->participationId;
    }

    public function getTitulaireOuRemplacant(): TitulaireOuRemplacant
    {
        return $this->titulaireOuRemplacant;
    }

    public function estTitulaire() {
        return $this->titulaireOuRemplacant === TitulaireOuRemplacant::TITULAIRE;
    }

    public function estRemplacant() {
        return $this->titulaireOuRemplacant === TitulaireOuRemplacant::REMPLACANT;
    }

    public function setTitulaireOuRemplacant(TitulaireOuRemplacant $titulaireOuRemplacant): void
    {
        $this->titulaireOuRemplacant = $titulaireOuRemplacant;
    }

    public function notePerformance(): int {
        return $this->performance !== null ? $this->performance->value : 0;
    }

    public function getPerformance(): ?Performance
    {
        return $this->performance;
    }

    public function setPerformance(?Performance $performance): void
    {
        $this->performance = $performance;
    }

    public function getPoste(): Poste
    {
        return $this->poste;
    }

    public function setPoste(Poste $poste): void
    {
        $this->poste = $poste;
    }
}

