<?php
declare(strict_types=1);

namespace App\Services;

use App\Config;

class EnvioVencimientoService
{
    private Config $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * Realiza los envios de Whatsapp y correo con la info de los medicamentos y 
     * dispositicos proximos a vencer.
    */ 
    public function enviar(array $data)
    {
        try {
            $this->enviarEmail($data);
            $this->enviarWhatsapp($data);
        } catch(\Exception $e) {
            throw $e;
        }
    }

    /**
     * Realiza el envio del correo con los medicamentos y dispositicos
    */
    private function enviarEmail(array $data): bool
    {
        try {
            $html = $this->getMarkup($data);
            echo $html;

            // implementar
            return true;
        } catch(\Exception $e) {
            throw $e;
        }
    }

    /**
     * Realiza el envio del correo con los medicamentos y dispositicos
    */
    private function enviarWhatsapp(array $data): bool
    {
        try {
            // implementar
            return true;
        } catch(\Exception $e) {
            throw $e;
        }
    }

    /**
     * Genera el HTML que sera enviado en el correo
    */
    private function getMarkup(array $data): string
    {
        ob_start();
        require $this->config->get("assets.templates") . "/mails/envio-vencidos.php";
        $HTML = ob_get_contents();
        ob_end_clean();

        return $HTML;
    }
}
