<?php
declare(strict_types=1);

require_once __DIR__ . '/config/bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('index.php');
}

if (!csrf_is_valid($_POST['csrf_token'] ?? null)) {
    set_flash('danger', 'We could not verify that request. Please try signing out again.');
    redirect(is_logged_in() ? 'dashboard.php' : 'index.php');
}

$_SESSION = [];

if (ini_get('session.use_cookies')) {
    $cookie = session_get_cookie_params();
    setcookie(session_name(), '', [
        'expires' => time() - 42000,
        'path' => $cookie['path'],
        'domain' => $cookie['domain'],
        'secure' => $cookie['secure'],
        'httponly' => $cookie['httponly'],
        'samesite' => $cookie['samesite'] ?? 'Lax',
    ]);
}

session_destroy();
session_start();
session_regenerate_id(true);
set_flash('success', 'You have been signed out safely.');
redirect('index.php');
