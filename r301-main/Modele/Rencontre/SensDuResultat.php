<?php

namespace rencontre;

enum SensDuResultat {
    case GAGNE;
    case EGALITE;
    case PERDU;

    public function getName(): string {
        return $this->name;
    }

    public static function fromResultat(Resultat $aPartirDuquelCalculerLeSens): SensDuResultat {
        $scoreDeLequipe = $aPartirDuquelCalculerLeSens->getScoreDeLequipe();
        $scoreDesAdversaires = $aPartirDuquelCalculerLeSens->getScoreDesAdversaires();

        if ($scoreDeLequipe > $scoreDesAdversaires) {
            return SensDuResultat::GAGNE;
        } else if ($scoreDeLequipe < $scoreDesAdversaires) {
            return SensDuResultat::PERDU;
        } else {
            return SensDuResultat::EGALITE;
        }
    }
}
