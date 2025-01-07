<?php
require_once __DIR__ . '/../config/database.php';

const SESSION_LIFETIME = 120 * 60; // in secunde 

function require_role($allowed_roles)
{
    if (!isset($_SESSION['user']['is_admin'])) {
        redirect_to('../pagini/auth.php');
    }

    $roles = [];
    if ($_SESSION['user']['is_admin']) {
        $roles[] = 'admin';
    } elseif (!$_SESSION['user']['is_admin']) {
        $roles[] = 'user';
    }

    if (!in_array($roles[0], $allowed_roles)) {
        redirect_to("../pagini/access_denied.php");
    }
}

function check_session_expiry()
{
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > SESSION_LIFETIME)) {
        session_unset();     // unset $_SESSION variable for the run-time 
        session_destroy();   // destroy session data in storage
        redirect_to('auth.php?form=login');
    }
    $_SESSION['last_activity'] = time();
}


//generare token pentru acces temporar la fisierul de procesare a informatiilor din formular
function generate_form_token()
{
    if (empty($_SESSION['form_token'])) {
        $_SESSION['form_token'] = generate_random_number(32);
    }
    return $_SESSION['form_token'];
}
