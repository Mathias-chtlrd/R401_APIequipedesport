<?php

namespace R301\Modele\Rencontre;
enum RencontreLieu {
    case DOMICILE;
    case EXTERIEUR;

    public static function fromName(string $name): ?RencontreLieu
    {
        foreach (self::cases() as $lieu) {
            if( $name === $lieu->name ){
                return $lieu;
            }
        }

        return null;
    }
}
