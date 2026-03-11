<?php

namespace R301\Modele\Statistiques;

use R301\Modele\Rencontre\RencontreResultat;

class StatistiquesEquipe {
    private readonly array $rencontres;

    public function __construct(
        array $rencontres
    ) {
        $this->rencontres = $rencontres;
    }

    private function nbMatchsJoues(): int {
        return count(array_filter($this->rencontres, function($rencontre) { return $rencontre->joue();}));
    }

    public function nbVictoires(): int {
        return count(array_filter($this->rencontres, function($rencontre) { return $rencontre->gagne(); }));
    }

    public function nbNuls(): int {
        return count(array_filter($this->rencontres, function($rencontre) { return $rencontre->nul(); }));
    }

    public function nbDefaites(): int {
        return count(array_filter($this->rencontres, function($rencontre) { return $rencontre->perdu() ;}));
    }

    public function pourcentageDeVictoires(): int {
        return $this->nbVictoires() / $this->nbMatchsJoues() * 100;
    }

    public function pourcentageDeNuls(): int {
        return $this->nbNuls() / $this->nbMatchsJoues() * 100;
    }

    public function pourcentageDeDefaites(): int {
        return $this->nbDefaites() / $this->nbMatchsJoues() * 100;
    }
}


