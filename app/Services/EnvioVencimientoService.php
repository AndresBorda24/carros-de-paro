<?php
declare(strict_types=1);

namespace App\Services;

use App\Config;
use PHPMailer\PHPMailer\PHPMailer;

class EnvioVencimientoService
{
    private Config $config;
    /**
     * Telefonos al que se enviara el mensaje de whatsapp
    */
    private array $telefonos = [
        "3209353216", // Andres
        "3116390529", // Nicolas
        // Aqui va el telefono de farmacia (creo)
    ];

    /**
     * Correo al que se debe enviar la info.
    */
    private array $correos = [
        "soporte@asotrauma.com.co"
    ];

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

            // Documentacion de PHPMailer:
            // https://github.com/PHPMailer/PHPMailer/
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->SMTPDebug = \PHPMailer\PHPMailer\SMTP::DEBUG_OFF;
            $mail->Host = 'mail.asotrauma.com.co';
            $mail->Port = 465;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->SMTPAuth = true;
            // $mail->SMTPSecure = 'tls';
            // Credenciales
            $mail->Username = 'envio.correos@asotrauma.com.co';
            $mail->Password = 'Asotrauma2018';
            // Entiendo que aqui puede ir otro correo, no necesariamente debe
            // corresponder con el Username
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
            $curl = curl_init();

            foreach($this->telefonos as $telefono) {
                curl_setopt_array($curl, [
                    CURLOPT_URL => "https://api.ultramsg.com/instance4491/messages/chat",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_SSL_VERIFYHOST => 0,
                    CURLOPT_SSL_VERIFYPEER => 0,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => http_build_query([
                        "to"    => $telefono,
                        "body"  => $body,
                        "token" => "svd2x9nz46at55kw",
                        "priority" => 1
                    ]),
                    CURLOPT_HTTPHEADER => [
                        "content-type: application/x-www-form-urlencoded"
                    ]
                ]);

                curl_exec($curl);
                $err = curl_error($curl);

                if ($err) echo "cURL Error #:" . $err;
            }

            curl_close($curl);
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
