<?php
declare(strict_types=1);

namespace App\Services;

use App\Config;
use PHPMailer\PHPMailer\PHPMailer;
use UltraMsg\WhatsAppApi;

class EnvioVencimientoService
{
    private Config $config;
    private WhatsAppApi $wp;

    /**
     * Telefonos al que se enviara el mensaje de whatsapp
    */
    private array $telefonos = [
        "3209353216", // Andres
        // "3116390529", // Nicolas
        // Aqui va el telefono de farmacia (creo)
        "3102837720", // Farmacia
    ];

    /**
     * Correo al que se debe enviar la info.
    */
    private array $correos = [
        "soporte@asotrauma.com.co",
        "coordinacionfarmacia@asotrauma.com.co"
    ];

    public function __construct(Config $config, WhatsAppApi $wp)
    {
        $this->config = $config;
        $this->wp = $wp;
    }

    /**
     * Realiza los envios de Whatsapp y correo con la info de los medicamentos y
     * dispositicos proximos a vencer.
    */
    public function enviar(array $data)
    {
        try {
            if( empty($data) ) {
                echo "No data to send";
                return true;
            }

            if( empty($data["medicamentos"]) && empty($data["dispositivos"]) ) {
                echo "No data to send";
                return true;
            }

            $this->enviarWhatsapp($data);
            $this->enviarEmail($data);
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

            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->SMTPDebug = \PHPMailer\PHPMailer\SMTP::DEBUG_OFF;
            $mail->Host = 'mail.asotrauma.com.co';
            $mail->Port = 465;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->SMTPAuth = true;
            $mail->Username = 'envio.correos@asotrauma.com.co';
            $mail->Password = 'Asotrauma2018';
            $mail->setFrom("referencia2@asotrauma.com.co");
            $mail->Subject = "Vencimientos | Carro de paro";
            $mail->msgHTML($html);


            // A quienes se envia el correo
            array_walk($this->correos, fn($c) => $mail->addAddress($c));

            if (!$mail->send()) {
                echo 'Mailer Error: ' . $mail->ErrorInfo;
                return false;
            } else {
                echo 'Correos Enviados...';
                return true;
            }
        } catch(\Exception $e) {
            throw $e;
        }
    }

    /**
     * Realiza el envio a whatsapp con los medicamentos y dispositicos
    */
    private function enviarWhatsapp(array $data): bool
    {
        try {
            $body = "_*Vencimientos | Carro de Paro*_ \n\n". $this->getWpBody($data);

            foreach($this->telefonos as $telefono) {
                $this->wp->sendChatMessage($telefono, $body, 1);
            }

            echo "\nWhatsapp enviados...";
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

    /**
     * Genera el HTML que sera enviado en el correo
    */
    private function getWpBody(array $data): string
    {
        ob_start();
        require $this->config->get("assets.templates") . "/mails/envio-vencidos-wp.php";
        $body = ob_get_contents();
        ob_end_clean();

        return $body ? $body : "-- Error --";
    }
}
