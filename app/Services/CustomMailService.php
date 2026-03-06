<?php

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class CustomMailService
{
    public function sendPHPMail($to, $subject, $message)
    {
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host       = env('MAIL_HOST');       // smtp.gmail.com
            $mail->SMTPAuth   = true;
            $mail->Username   = env('MAIL_USERNAME');   // vinniemariba2004@gmail.com
            $mail->Password   = env('MAIL_PASSWORD');   // kzdm fher kqvc uuvh
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // For Port 465 (SSL)
            $mail->Port       = env('MAIL_PORT');       // 465

            // SSL Fix for Localhost (XAMPP/Windows often needs this)
            $mail->SMTPOptions = [
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                ]
            ];

            // Recipients
            $mail->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            $mail->addAddress($to);

            // Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $message;
            $mail->AltBody = strip_tags($message);

            $mail->send();
            return true;
        } catch (Exception $e) {
            return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}