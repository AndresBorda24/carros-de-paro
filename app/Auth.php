<?php
declare(strict_types=1);

namespace App;

use Medoo\Medoo;
use App\Models\User;
use App\Contracts\UserInterface;

class Auth
{
    private Medoo $db;
    private Session $session;
    private ?UserInterface $user = null;

    public function __construct(Session $session, Medoo $db)
    {
        $this->db = $db;
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

        $id = $this->session->get("usu_id", 133); // 133 // 617
        if(! $id) return null;

        $data = $this->db->get(User::TABLE, [
            "usuario_id (id)",
            "usuario_grupo (grupo)",
            "area_servicio_id (areaId)",
            "cargo_id"
        ], [
            "usuario_id" => $id
        ]);

        if (!$data) return null;

        $this->user = new User($data);
        return $this->user;
    }
}
