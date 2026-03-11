<?php
namespace R301\Modele\Participation;

enum TitulaireOuRemplacant
{
    case TITULAIRE;
    case REMPLACANT;

    public static function fromName(string $name): ?TitulaireOuRemplacant
    {
        foreach (self::cases() as $status) {
            if( $name === $status->name ){
                return $status;
            }
        }

        return null;
    }
}
