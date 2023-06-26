<?php
declare(strict_types=1);

namespace App\Models;

use App\Contracts\UserInterface;

class User implements UserInterface
{
    public const TABLE = "usuario";

    private int $id;
    private int $areaId;
    private int $cargoId;
    private string $grupo;
    private string $nombre;


    public function __construct(array $data)
    {
        try {
            $this->checkData($data);

            $this->id      = (int) $data["id"];
            $this->grupo   = $data["grupo"];
            $this->areaId  = (int) $data["areaId"];
            $this->cargoId = (int) $data["cargo_id"];
            $this->nombre  = $data["nombre"];
        } catch(\Exception $e) {
            throw $e;
        }
    }

    public function getGrupo(): string
    {
        return $this->grupo;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getAreaId(): int
    {
        return $this->areaId;
    }

    public function getCargoId(): int
    {
        return $this->cargoId;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    // Revisa los campos requeridos
    private function checkData(array $data): bool
    {
        foreach(["id", "areaId", "grupo", "cargo_id"]as $key) {
            if(! array_key_exists($key, $data)) {
                throw new \RuntimeException("Faltan datos usuario");
            }
        }

        return true;
    }
}
