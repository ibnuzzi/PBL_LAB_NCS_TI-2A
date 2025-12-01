<?php
// File: /app/services/EmailService.php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class EmailService
{
    private $config;
    private $mailer;

    public function __construct()
    {
        // Load SMTP configuration
        $this->config = require './app/config/email_config.php';
        
        // Initialize PHPMailer
        $this->mailer = new PHPMailer(true);
        $this->setupSMTP();
    }

    /**
     * Configure SMTP settings
     */
    private function setupSMTP()
    {
        try {
            // Server settings
            if ($this->config['debug_mode']) {
                $this->mailer->SMTPDebug = SMTP::DEBUG_OFF; // Disable debug output in production
            }
            
            $this->mailer->isSMTP();
            $this->mailer->Host       = $this->config['smtp_host'];
            $this->mailer->SMTPAuth   = true;
            $this->mailer->Username   = $this->config['smtp_username'];
            $this->mailer->Password   = $this->config['smtp_password'];
            $this->mailer->SMTPSecure = $this->config['smtp_encryption'];
            $this->mailer->Port       = $this->config['smtp_port'];
            
            // Default sender
            $this->mailer->setFrom($this->config['from_email'], $this->config['from_name']);
            
            // Character encoding
            $this->mailer->CharSet = 'UTF-8';
            
        } catch (Exception $e) {
            error_log("Email configuration error: " . $e->getMessage());
        }
    }

    /**
     * Send acceptance email to user
     * 
     * @param string $to User's email address
     * @param string $nama User's name
     * @param string $pertanyaan User's question
     * @param string $jawaban Admin's answer
     * @return bool True if email sent successfully
     */
    public function sendAcceptanceEmail($to, $nama, $pertanyaan, $jawaban)
    {
        try {
            // Recipients
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($to, $nama);
            
            // Content
            $this->mailer->isHTML(true);
            $this->mailer->Subject = 'Konsultasi Anda Telah Dijawab - Lab NCS';
            $this->mailer->Body    = $this->getAcceptanceEmailTemplate($nama, $pertanyaan, $jawaban);
            $this->mailer->AltBody = strip_tags($this->getAcceptanceEmailTemplate($nama, $pertanyaan, $jawaban));
            
            // Send email
            $result = $this->mailer->send();
            
            // Clear attachments and addresses for next email
            $this->mailer->clearAttachments();
            
            return $result;
            
        } catch (Exception $e) {
            error_log("Email sending failed: " . $this->mailer->ErrorInfo);
            return false;
        }
    }

    /**
     * Send rejection email to user
     * 
     * @param string $to User's email address
     * @param string $nama User's name
     * @param string $pertanyaan User's question
     * @param string $alasan Rejection reason
     * @return bool True if email sent successfully
     */
    public function sendRejectionEmail($to, $nama, $pertanyaan, $alasan)
    {
        try {
            // Recipients
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($to, $nama);
            
            // Content
            $this->mailer->isHTML(true);
            $this->mailer->Subject = 'Pemberitahuan Konsultasi - Lab NCS';
            $this->mailer->Body    = $this->getRejectionEmailTemplate($nama, $pertanyaan, $alasan);
            $this->mailer->AltBody = strip_tags($this->getRejectionEmailTemplate($nama, $pertanyaan, $alasan));
            
            // Send email
            $result = $this->mailer->send();
            
            // Clear attachments and addresses for next email
            $this->mailer->clearAttachments();
            
            return $result;
            
        } catch (Exception $e) {
            error_log("Email sending failed: " . $this->mailer->ErrorInfo);
            return false;
        }
    }

    /**
     * Get HTML template for acceptance email
     */
    private function getAcceptanceEmailTemplate($nama, $pertanyaan, $jawaban)
    {
        return '
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #1a237e; color: white; padding: 20px; text-align: center; }
        .content { background-color: #f9f9f9; padding: 20px; margin-top: 20px; }
        .question-box { background-color: #fff; border-left: 4px solid #ff5722; padding: 15px; margin: 15px 0; }
        .answer-box { background-color: #fff; border-left: 4px solid #4caf50; padding: 15px; margin: 15px 0; }
        .footer { text-align: center; margin-top: 20px; font-size: 12px; color: #777; }
        h2 { color: #1a237e; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Lab NCS - Politeknik Negeri Malang</h1>
        </div>
        
        <div class="content">
            <p>Yth. <strong>' . htmlspecialchars($nama) . '</strong>,</p>
            
            <p>Terima kasih telah menghubungi Lab Network and Cyber Security (NCS) - Politeknik Negeri Malang.</p>
            
            <p>Konsultasi Anda telah <strong>diterima dan dijawab</strong> oleh tim kami.</p>
            
            <div class="question-box">
                <strong>Pertanyaan Anda:</strong><br>
                ' . nl2br(htmlspecialchars($pertanyaan)) . '
            </div>
            
            <div class="answer-box">
                <strong>Jawaban dari Tim Lab NCS:</strong><br>
                ' . nl2br(htmlspecialchars($jawaban)) . '
            </div>
            
            <p>Jika Anda memiliki pertanyaan lebih lanjut, jangan ragu untuk menghubungi kami kembali melalui website atau email kami di <a href="mailto:ncs@polinema.ac.id">ncs@polinema.ac.id</a>.</p>
            
            <p>Salam,<br>
            <strong>Tim Lab NCS</strong><br>
            Politeknik Negeri Malang</p>
        </div>
        
        <div class="footer">
            <p>Email ini dikirim secara otomatis. Mohon tidak membalas email ini.</p>
            <p>Lab Network and Cyber Security - Gedung JTI, Politeknik Negeri Malang</p>
        </div>
    </div>
</body>
</html>
        ';
    }

    /**
     * Get HTML template for rejection email
     */
    private function getRejectionEmailTemplate($nama, $pertanyaan, $alasan)
    {
        return '
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #1a237e; color: white; padding: 20px; text-align: center; }
        .content { background-color: #f9f9f9; padding: 20px; margin-top: 20px; }
        .question-box { background-color: #fff; border-left: 4px solid #ff5722; padding: 15px; margin: 15px 0; }
        .reason-box { background-color: #fff; border-left: 4px solid #f44336; padding: 15px; margin: 15px 0; }
        .footer { text-align: center; margin-top: 20px; font-size: 12px; color: #777; }
        h2 { color: #1a237e; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Lab NCS - Politeknik Negeri Malang</h1>
        </div>
        
        <div class="content">
            <p>Yth. <strong>' . htmlspecialchars($nama) . '</strong>,</p>
            
            <p>Terima kasih telah menghubungi Lab Network and Cyber Security (NCS) - Politeknik Negeri Malang.</p>
            
            <p>Kami telah meninjau konsultasi Anda, namun dengan hormat kami sampaikan bahwa konsultasi ini tidak dapat kami proses lebih lanjut.</p>
            
            <div class="question-box">
                <strong>Pertanyaan Anda:</strong><br>
                ' . nl2br(htmlspecialchars($pertanyaan)) . '
            </div>
            
            <div class="reason-box">
                <strong>Alasan:</strong><br>
                ' . nl2br(htmlspecialchars($alasan)) . '
            </div>
            
            <p>Jika Anda memiliki pertanyaan yang sesuai dengan bidang keamanan siber dan jaringan, silakan hubungi kami kembali melalui website atau email kami di <a href="mailto:ncs@polinema.ac.id">ncs@polinema.ac.id</a>.</p>
            
            <p>Salam,<br>
            <strong>Tim Lab NCS</strong><br>
            Politeknik Negeri Malang</p>
        </div>
        
        <div class="footer">
            <p>Email ini dikirim secara otomatis. Mohon tidak membalas email ini.</p>
            <p>Lab Network and Cyber Security - Gedung JTI, Politeknik Negeri Malang</p>
        </div>
    </div>
</body>
</html>
        ';
    }
}
