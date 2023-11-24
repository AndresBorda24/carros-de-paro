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
     * accion
     * @param string $permiso Representa la llave del permiso en el array.
     * @param ?string $vista Para organizar algunos permisos por vistas. Representa
     *                       el nombre de la ruta actual. O una llave en el array
     *                       de permisos.
    */
    public function check(string $permiso, ?string $vista = null): bool
    {
        $listaPermisos =  ($vista !== null && array_key_exists($vista, $this->permisos))
            ? $this->permisos[ $vista ]
            : $this->permisos;


        if (! array_key_exists($permiso, $listaPermisos)) {
            return false;
        }

        if (in_array(
                $this->auth->getGrupo(),
                $listaPermisos[ $permiso ]["grupos"]
        )) {
            return true;
        }

        if (in_array(
                $this->auth->getCargoId(),
                $listaPermisos[ $permiso ]["cargos"]
        )) {
            return true;
        }

        if (in_array(
                $this->auth->getAreaId(),
                $listaPermisos[ $permiso ]["area"]
        )) {
            return true;
        }

        if (in_array(
                $this->auth->getId(),
                $listaPermisos[ $permiso ]["id"]
        )) {
            return true;
        }

        return false;
    }
}
