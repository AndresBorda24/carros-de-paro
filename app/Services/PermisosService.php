<?php
declare(strict_types=1);

namespace App\Services;

use App\Auth;
use App\Config;
use App\Contracts\UserInterface;

class PermisosService
{
    private UserInterface $auth;
    private array $permisos;

    public function __construct(Auth $auth, Config $config)
    {
        $this->auth = $auth->user();
        $this->permisos = $config->get("permisos");
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
                $this->auth->getAreaId(),
                $this->permisos[ $permiso ]["area"]
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
