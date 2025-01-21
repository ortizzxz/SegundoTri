<?php
namespace Lib;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class EmailSender
{
    private $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);
        $this->setupSMTP();
    }

    private function setupSMTP()
    {
        $this->mail->isSMTP();
        $this->mail->Host = $_ENV['SMTP_HOST']; 
        $this->mail->SMTPAuth = true;
        $this->mail->Username = $_ENV['SMTP_USERNAME'];
        $this->mail->Password = $_ENV['SMTP_PASSWORD'];
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
        $this->mail->Port = $_ENV['SMTP_PORT'];
    }

    public function sendEmail($recipientEmail, $recipientName, $subject, $body)
    {
        try {
            $this->mail->setFrom('from@example.com', 'Your Company');
            $this->mail->addAddress($recipientEmail, $recipientName);

            $this->mail->isHTML(true);
            $this->mail->Subject = $subject;
            $this->mail->Body = $body;
            $this->mail->AltBody = strip_tags($body);
            return $this->mail->send();
        } catch (Exception $e) {
            echo "Error enviando el correo: {$this->mail->ErrorInfo}";
            return false;
        }
    }
}

