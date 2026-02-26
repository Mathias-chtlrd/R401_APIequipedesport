<?php
namespace R301\Modele\Joueur;

enum JoueurStatut
{
    case ACTIF;
    case BLESSE;
    case ABSENT;
    case SUSPENDU;

    public static function fromName(string $name): ?JoueurStatut
    {
        foreach (self::cases() as $status) {
            if( $name === $status->name ){
                return $status;
            }
        }

        return null;
    }
}
