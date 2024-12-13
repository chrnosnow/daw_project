<?php

function view(string $filename, array $data = [])
{
    // create variables from the associative array
    foreach ($data as $key => $value) {
        $$key = $value;
    }
    require_once __DIR__ . '/../fragmente/' . $filename . '.php';
}

function is_post_req()
{
    return strtoupper($_SERVER['REQUEST_METHOD']) === 'POST';
}


function is_get_req()
{
    return strtoupper($_SERVER['REQUEST_METHOD']) === 'GET';
}

function display_alert(string $key)
{
    if (!isset($key) || !isset($_SESSION[$key])) {
        return;
    }

    $messages = $_SESSION[$key];
    unset($_SESSION[$key]);
    foreach ($messages as $msg_key => $msg_string) {
        echo '<div class="' . $key . '">' . '<p>' . $msg_string . '</p></div>';
    }
}

function redirect_to(string $url): void
{
    header('Location:' . $url);
    exit;
}

function randomNumber($length)
{
    //half the length because each byte is 
    //represented by two hexadecimal characters
    $bytes = random_bytes($length / 2);
    //convert bytes to hexadecimal string
    $rnd = bin2hex($bytes);

    return $rnd;
}
