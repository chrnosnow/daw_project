<?php
// define('ALLOWED_ACCESS', true);

//cookie_check
// header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // seteaza cookie-ul cand utilizatorul accepta
    setcookie('cookies_accepted', '1', time() + (20), "/"); // add seconds
    echo json_encode(['status' => 'success']);
    exit;
}

$show_banner = !isset($_COOKIE['cookies_accepted']) || $_COOKIE['cookies_accepted'] !== '1';
