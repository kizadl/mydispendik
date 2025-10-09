<?php

function start_secure_session() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
}

function generate_csrf_token() {
    start_secure_session();
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function rotate_csrf_token() {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf_token'];
}

function validate_csrf_token_or_exit($token_from_client) {
    start_secure_session();

    if (!isset($_SESSION['csrf_token'])) {
        http_response_code(403);
        echo json_encode(['error' => 'CSRF token not set in session']);
        exit;
    }

    if (!hash_equals($_SESSION['csrf_token'], $token_from_client)) {
        http_response_code(403);
        echo json_encode(['error' => 'CSRF token mismatch']);
        exit;
    }

    // OPTIONAL
    if (!isset($_SERVER['HTTP_REFERER']) || strpos($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST']) === false) {
        http_response_code(403);
        echo json_encode(['error' => 'Invalid referer']);
        exit;
    }
}
