<?php
declare(strict_types=1);

namespace App\Contracts;

/**
 * Representa los metodos que debe tener la clase o Modelo User
*/
interface UserInterface
{
    public function getGrupo(): string;

    public function getId(): int;

    public function getAreaId(): int;

    public function getCargoId(): int;

    public function getNombre(): string;
}
