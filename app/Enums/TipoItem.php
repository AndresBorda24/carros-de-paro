<?php
declare(strict_types=1);

namespace App\Enums;

use MyCLabs\Enum\Enum;

final class TipoItem extends Enum
{
    private const MEDICAMENTO  = "Medicamento";
    private const DISPOSITIVO  = "Dispositivo";

    public static function MEDICAMENTO(): TipoItem
    {
        return new static(static::MEDICAMENTO);
    }

    public static function DISPOSITIVO(): TipoItem
    {
        return new static(static::DISPOSITIVO);
    }
}
