<?php
namespace R301\Modele\Participation;

enum Performance: int
{
    case EXCELLENTE = 5;
    case BONNE = 4;
    case MOYENNE = 3;
    case MAUVAISE = 2;
    case CATASTROPHIQUE = 1;

    public static function fromName(string $name): ?Performance
    {
        foreach (self::cases() as $performance) {
            if( $name === $performance->name ){
                return $performance;
            }
        }

        return null;
    }

    public static function fromValue(int $value): ?Performance
    {
        foreach (self::cases() as $performance) {
            if( $value === $performance->value ){
                return $performance;
            }
        }

        return null;
    }
}
