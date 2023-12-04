<?php
declare(strict_types=1);

namespace App;

use Medoo\Medoo;
use App\Models\User;
use App\Contracts\UserInterface;

class Auth
{
    private Medoo $db;
    private Config $config;
    private Session $session;
    private ?UserInterface $user = null;

    public function __construct(
        Session $session,
        Config $config,
        Medoo $db
    ) {
        $this->db = $db;
        $this->config = $config;
        $this->session = $session;
    }

    /**
     * Retorna el usuario que esta actualmente loggeado
    */
    public function user(): ?UserInterface
    {
        if($this->user !== null) {
            return $this->user;
        }

        $id = ($this->config->get("app.env") == "prod")
            ? $this->session->get("usu_id")
            : 617; // 133: Merly | 617: Andres | 603: Marly | 172: Nohemy

        if(! $id) return null;

        $data = $this->db->get(User::TABLE, [
            "usuario_id (id)",
            "usuario_grupo (grupo)",
            "area_servicio_id (areaId)",
            "cargo_id",
            "nombre" => Medoo::raw("CONCAT_WS(
                    ' ',
                    `usuario_apellido1`,
                    `usuario_apellido2`,
                    `usuario_nombre1`,
                    `usuario_nombre2`
            )")
        ], [
            "usuario_id" => $id
        ]);

        if (!$data) return null;

        $this->user = new User($data);
        return $this->user;
    }
}
