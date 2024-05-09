<?php

require_once '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class CorreosModel
{
    private $mail;
    private $pass = 'Asotaeco1@';

    public function enviarCorreo()
    {
        try {
            $email = $_POST['email'];
            $nombre = $_POST['nombre'];
            $asunto = $_POST['asunto'];
            $body = $_POST['mensaje'];
            $foto = $_POST['foto'];

            $this->mail = new PHPMailer(true);
            $this->mail->isSMTP();
            $this->mail->Host = 'smtp.hostinger.com';
            $this->mail->SMTPAuth = true;
            $this->mail->Username = 'info@asotaeco.com';
            $this->mail->Password = $this->pass;
            $this->mail->SMTPSecure = 'ssl';
            $this->mail->Port = 465;
            $this->mail->setFrom('info@asotaeco.com', 'Asotaeco');
            $this->mail->addAddress($email, $nombre);
            $this->mail->isHTML(true);
            $this->mail->Subject = $asunto;
            $this->mail->Body = $body;
            $this->mail->AltBody = strip_tags($body);

            // Adjuntar la foto al correo electrónico
            if ($foto['size'] > 0) {
                $this->mail->addAttachment($foto['tmp_name'], $foto['name']);
            }

            $rta = $this->mail->send();
            return "El correo se ha enviado correctamente." . $rta;
        } catch (Exception $e) {
            return "Ha ocurrido un error al enviar el correo: " . $e->getMessage();
        }
    }

    public function enviarCorreoPersonalizado($email, $asunto, $mensajeHTML)
    {
        try {
            $this->mail = new PHPMailer(true);
            $this->mail->isSMTP();
            $this->mail->Host = 'smtp.hostinger.com';
            $this->mail->SMTPAuth = true;
            $this->mail->Username = 'info@asotaeco.com';
            $this->mail->Password = $this->pass;
            $this->mail->SMTPSecure = 'ssl';
            $this->mail->Port = 465;
            $this->mail->setFrom('info@asotaeco.com', 'Asotaeco');
            $this->mail->addAddress($email);
            $this->mail->CharSet = 'UTF-8'; // Establecer la codificación UTF-8
            $this->mail->Encoding = 'base64'; // Codificación base64
            $this->mail->isHTML(true);
            $this->mail->Subject = '=?UTF-8?B?' . base64_encode($asunto) . '?='; // Establecer el asunto codificado en base64 UTF-8
            $this->mail->Body = $mensajeHTML;
            $this->mail->AltBody = strip_tags($mensajeHTML);


            // Intenta enviar el correo
            if ($this->mail->send()) {
                return "El correo se ha enviado correctamente.";
            } else {
                return "El correo no se pudo enviar. Por favor, inténtalo de nuevo más tarde.";
            }
        } catch (Exception $e) {
            return "Ha ocurrido un error al enviar el correo: " . $e->getMessage();
        }
    }

    public function enviarCorreoPDF($email, $asunto, $mensajeHTML, $pdfContent)
    {
        try {
            $this->mail = new PHPMailer(true);
            $this->mail->isSMTP();
            $this->mail->Host = 'smtp.hostinger.com';
            $this->mail->SMTPAuth = true;
            $this->mail->Username = 'info@asotaeco.com';
            $this->mail->Password = $this->pass;
            $this->mail->SMTPSecure = 'ssl';
            $this->mail->Port = 465;
            $this->mail->setFrom('info@asotaeco.com', 'Asotaeco');
            $this->mail->addAddress($email);
            $this->mail->CharSet = 'UTF-8';
            $this->mail->Encoding = 'base64';
            $this->mail->isHTML(true);
            $this->mail->Subject = '=?UTF-8?B?' . base64_encode($asunto) . '?=';
            $this->mail->Body = $mensajeHTML;
            $this->mail->AltBody = strip_tags($mensajeHTML);
            $fechaHora = date('Y-m-d_H-i-s');
            $nombreArchivo = 'asotaeco_' . $fechaHora . '.pdf';

            
            $this->mail->AddStringAttachment($pdfContent, $nombreArchivo, 'base64', 'application/pdf');
            $this->mail->send();
            return "El correo se ha enviado correctamente en segundo plano.";
        } catch (Exception $e) {
            return "Ha ocurrido un error al enviar el correo: " . $e->getMessage();
        }
    }
}
