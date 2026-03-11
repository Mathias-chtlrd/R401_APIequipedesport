<?php

namespace R301\Modele\Statistiques;

use R301\Modele\Joueur\Joueur;
use R301\Modele\Participation\Poste;

class StatistiquesJoueurs {
    private readonly array $participations;
    private readonly array $rencontresJouees;

    public function __construct(
        array $participations,
        array $rencontres,
    ) {
        $this->participations = $participations;
        usort($rencontres, function ($a, $b) { return $a->getDateEtHeure() <=> $b->getDateEtHeure(); });
        $this->rencontresJouees = array_filter($rencontres, function ($rencontre) { return $rencontre->joue(); });
    }

    private function participationsDunJoueur(Joueur $joueur): array {
        return array_filter($this->participations, function ($participation) use ($joueur) {
            return $participation->getRencontre()->joue()
                && $participation->getParticipant()->getJoueurId() === $joueur->getJoueurId();
        });
    }

    private function participationsDunJoueurAuPoste(Joueur $joueur, Poste $poste): array {
        return array_filter($this->participations, function ($participation) use ($joueur, $poste) {
            return $participation->getRencontre()->joue()
                && $participation->getPoste() === $poste
                && $participation->getParticipant()->getJoueurId() === $joueur->getJoueurId();
        });
    }

    private function leJoueurAParticipeALaRencontre(Joueur $joueur, mixed $rencontre): bool {
        foreach ($this->participationsDunJoueur($joueur) as $participations) {
            if ($participations->getRencontre()->getRencontreId() === $rencontre->getRencontreId()) {
                return true;
            }
        }

        return false;
    }

    public function posteLePlusPerformant(Joueur $joueur): ?Poste {
        $participations = $this->participationsDunJoueur($joueur);
        if  (count($participations) === 0) {
            return null;
        } else {
            $moyenneParPoste = [];
            foreach (Poste::cases() as $poste) {
                $moyenneParPoste[$poste->name] = $this->moyenneDesEvaluationsPourLePoste($joueur, $poste);
            }

            arsort($moyenneParPoste);
            return Poste::fromName(array_key_first($moyenneParPoste));
        }
    }

    public function nbRencontresConsecutivesADate(Joueur $joueur): int {
        $nbRencontresConsecutivesADate = 0;

        foreach ($this->rencontresJouees as $rencontre) {
            if($this->leJoueurAParticipeALaRencontre($joueur, $rencontre)) {
                $nbRencontresConsecutivesADate++;
            } else {
                break;
            }
        }

        return $nbRencontresConsecutivesADate;
    }

    public function nbTitularisations(Joueur $joueur): int {
        return count(array_filter($this->participationsDunJoueur($joueur), function($participation) {
            return $participation->estTitulaire();
        }));
    }

    public function nbRemplacant(Joueur $joueur): int {
        return count(array_filter($this->participationsDunJoueur($joueur), function($participation) {
            return $participation->estRemplacant();
        }));
    }

    private function nbMatchsEvalues(Joueur $joueur): int {
        return count(
            array_filter($this->participationsDunJoueur($joueur), function($participation) {
                return $participation->getPerformance() !== null;
            })
        );
    }

    private function nbMatchsJoues(Joueur $joueur): int {
        return count(
            array_filter($this->participationsDunJoueur($joueur), function($participation) {
                return $participation->getRencontre()->getResultat() !== null;
            })
        );
    }

    private function nbMatchsGagnes(Joueur $joueur): int {
        return count(
            array_filter($this->participationsDunJoueur($joueur), function($participation) {
                return $participation->getRencontre()->gagne();
            })
        );
    }

    public function moyenneDesEvaluations(Joueur $joueur): ?float {
        $participations = $this->participationsDunJoueur($joueur);

        if ($this->nbMatchsEvalues($joueur) > 0) {
            return array_sum(array_map( function($participation) { return $participation->notePerformance(); }, $participations)) / $this->nbMatchsEvalues($joueur);
        } else {
            return null;
        }
    }

    private function moyenneDesEvaluationsPourLePoste(Joueur $joueur, Poste $poste) {
        $participations = $this->participationsDunJoueurAuPoste($joueur, $poste);

        if ($this->nbMatchsEvalues($joueur) > 0) {
            return array_sum(array_map( function($participation) { return $participation->notePerformance(); }, $participations)) / $this->nbMatchsEvalues($joueur);
        } else {
            return null;
        }
    }

    public function pourcentageDeMatchsGagnes(Joueur $joueur): ?int {
        if ($this->nbMatchsJoues($joueur) > 0) {
            return $this->nbMatchsGagnes($joueur) / $this->nbMatchsJoues($joueur) * 100;
        } else {
            return null;
        }
    }
}


