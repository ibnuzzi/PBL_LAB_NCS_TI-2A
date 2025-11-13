<?php
// File: app/middleware/AuthMiddleware.php
// Simple middleware to require admin authentication
class AuthMiddleware
{
    public static function requireAdmin()
    {
        if (!isset($_SESSION)) {
            @session_start();
        }
        if (empty($_SESSION['admin_logged_in'])) {
            $_SESSION['error_message'] = 'Anda harus login!';
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
    }
}
