<?php
// define('ALLOWED_ACCESS', true);
require_once __DIR__ . '/../lib/common.php';


//cookie_check
// header('Content-Type: application/json');
if (is_post_req() && isset($_POST['ok_cookies'])) {
    // seteaza cookie-ul cand utilizatorul accepta
    setcookie('cookies_accepted', '1', time() + (20), "/"); // add seconds
    echo json_encode(['status' => 'success']);
    // exit;
    redirect_to($_SERVER['HTTP_REFERER']);
}

$show_banner = !isset($_COOKIE['cookies_accepted']) || $_COOKIE['cookies_accepted'] !== '1';
