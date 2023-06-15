<?php
declare(strict_types=1);

namespace App\Services;

use App\Auth;
use App\Contracts\UserInterface;

class PermisosService
{
    private UserInterface $auth;

    /**
     * Listado de permisos. La llave sera el permiso y el valor los
     * grupos a los que se les tiene permitido esa accion
    */
    private array $permisos = [
        "carro.create" => [
            "grupos" => ['00'],
            "cargos" => [],
            "id"     => []
        ],
        "carro.edit"   => [
            "grupos" => ['00'],
            "cargos" => [],
            "id"     => []
        ],
        "carro.delete" => [
            "grupos" => ['00'],
            "cargos" => [],
            "id"     => []
        ],

        // Medicamentos
        "medicamentos.create" => [
            "grupos" => ['00'],
            "cargos" => [],
            "id"     => []
        ],
        "medicamentos.edit"   => [
            "grupos" => ['00'],
            "cargos" => [],
            "id"     => []
        ],
        "medicamentos.delete" => [
            "grupos" => ['00'],
            "cargos" => [],
            "id"     => []
        ],

        // Dispositivos
        "dispositivos.create" => [
            "grupos" => ['00'],
            "cargos" => [],
            "id"     => []
        ],
        "dispositivos.edit"   => [
            "grupos" => ['00'],
            "cargos" => [],
            "id"     => []
        ],
        "dispositivos.delete" => [
            "grupos" => ['00'],
            "cargos" => [],
            "id"     => []
        ],

        "grillas.ver-datos" => [
            "grupos" => ['00'],
            "cargos" => [],
            "id"     => []
        ]
    ];

    public function __construct(Auth $auth)
    {
        $this->auth = $auth->user();
    }

    /**
     * Revisa si el usuario loggeado actualmente puede realizar cierta
     * accion $permiso
    */
    public function check(string $permiso): bool
    {
        if (! array_key_exists($permiso, $this->permisos)) {
            return false;
        }

        if (in_array(
                $this->auth->getGrupo(),
                $this->permisos[ $permiso ]["grupos"]
        )) {
            return true;
        }

        if (in_array(
                $this->auth->getCargoId(),
                $this->permisos[ $permiso ]["cargos"]
        )) {
            return true;
        }

        if (in_array(
                $this->auth->getId(),
                $this->permisos[ $permiso ]["id"]
        )) {
            return true;
        }

        return false;
    }
}
