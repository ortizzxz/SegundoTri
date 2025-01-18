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
        $this->mail->Username = $_ENV['SMTP_USERNAME']; // SMTP username
        $this->mail->Password = $_ENV['SMTP_PASSWORD']; // SMTP password
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
        $this->mail->Port = $_ENV['SMTP_PORT']; // TCP port to connect to
    }

    public function sendEmail($recipientEmail, $recipientName, $subject, $body)
    {
        try {
            // Recipients
            $this->mail->setFrom('from@example.com', 'Your Company');
            $this->mail->addAddress($recipientEmail, $recipientName); // Add a recipient

            // Content
            $this->mail->isHTML(true); // Set email format to HTML
            $this->mail->Subject = $subject;
            $this->mail->Body = $body;
            $this->mail->AltBody = strip_tags($body); // Plain text version of the email

            // Send the email
            return $this->mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
            return false;
        }
    }
}

