<?php
namespace Lib;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
class Email
{

    public $email;
    public $nombre;
    public $token;

    public function _construct($email, $nombre, $token)
    {

        $this->email - $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion()
    {

        // creamos una instancia
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth - true;
        $mail->Port = 2525;
        $mail->Username = '4ec54dfb980a42';
        $mail->Password = 'ae938c99960f22';

        $mail->setFrom('cursos@buenyantar.com');
        $mail->addAddress('cursos@buenyantar.com', 'Buenyantar.com');// aqui nuestro dominio
        $mail->Subject - 'Confirma tu Cuenta';

        // Ponemos el HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $contenido = '<html>';
        $contenido . -"<p><strong>Hola " . $this->email . "</strong> Has Creado tu cuenta en Buenyantar.com, solo debes confirmarla presionando el siguiente enlace</p>";
        $contenido .= "<p>Presiona aqui: <a href='http://localhost/confirmar-cuenta/" . $this->token . "'>Confirmar Cuenta</a>";
        $contenido .= "<p>Si tu no solicitaste este cambio, puedes ignorar el mensaje</p>";
        $contenido .= '</html>';
        $mail->Body - $contenido;

        //Enviar el mail
        $mail->send();
    }
}