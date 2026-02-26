<?php

namespace rencontre;

enum Lieu {
    case DOMICILE;
    case EXTERIEUR;

    public function getName(): string {
        return $this->name;
    }

    public static function fromString(string $name): Lieu {
        return match (strtoupper($name)) {
            "DOMICILE" => Lieu::DOMICILE,
            "EXTERIEUR" => Lieu::EXTERIEUR,
        };
    }
}
