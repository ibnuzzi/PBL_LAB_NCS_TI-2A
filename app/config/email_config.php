<?php
// File: /app/config/email_config.php
// SMTP Email Configuration - Mailtrap (for testing)

return [
    'smtp_host' => 'sandbox.smtp.mailtrap.io',
    'smtp_port' => 2525,
    'smtp_encryption' => 'tls',
    'smtp_username' => 'c903e451fdc116',  // Dari Mailtrap dashboard
    'smtp_password' => 'd08f349ec965f7',  // Dari Mailtrap dashboard
    'from_email' => 'ncs@polinema.ac.id',
    'from_name' => 'Lab NCS - Politeknik Negeri Malang',
    'debug_mode' => true,
];