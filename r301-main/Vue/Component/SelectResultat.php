<?php

namespace R301\Vue\Component;

use R301\Modele\Rencontre\RencontreResultat;

class SelectResultat extends Select {
    public function __construct(
        ?string $description,
        ?string $selectedValue = null
    ) {
        $values = [];
        foreach (RencontreResultat::cases() as $resultat) {
            $values[$resultat->name] = $resultat->name;
        }

        parent::__construct($values, "resultat", $description, $selectedValue);
    }
}