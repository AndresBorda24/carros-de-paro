<?php
declare(strict_types=1);

namespace App\Enums;

use MyCLabs\Enum\Enum;

final class CarroTipo extends Enum
{
    private const ESTANTE = "ES";
    private const CARRO = "CA";

    /** ES */
    public static function ESTANTE(): CarroTipo
    {
        return new CarroTipo(self::ESTANTE);
    }

    /** CA */
    public static function CARRO(): CarroTipo
    {
        return new CarroTipo(self::CARRO);
    }
}
