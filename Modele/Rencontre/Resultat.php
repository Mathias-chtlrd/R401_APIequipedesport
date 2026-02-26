<?php

namespace rencontre;

class Resultat {
    private int $scoreDeLequipe;
    private int $scoreDesAdversaires;

    public function __construct(int $scoreDeLequipe, int $scoreDesAdversaires) {
        $this->scoreDeLequipe = $scoreDeLequipe;
        $this->scoreDesAdversaires = $scoreDesAdversaires;
    }

    public static function constructFromDB(
        int $scoreDeLequipe,
        int $scoreDesAdversaires
    ) : Resultat {
        return new Resultat($scoreDeLequipe, $scoreDesAdversaires);
    }

    public function getSensDuResultat(): SensDuResultat {
        return SensDuResultat::fromResultat($this);
    }

    public function getScoreDeLequipe(): int {
        return $this->scoreDeLequipe;
    }

    public function setScoreDeLequipe(int $scoreDeLequipe): void {
        $this->scoreDeLequipe = $scoreDeLequipe;
    }

    public function getScoreDesAdversaires(): int {
        return $this->scoreDesAdversaires;
    }

    public function setScoreDesAdversaires(int $scoreDesAdversaires): void {
        $this->scoreDesAdversaires = $scoreDesAdversaires;
    }
}
