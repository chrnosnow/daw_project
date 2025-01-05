<?php
require_once __DIR__ . '/../config/database.php';

const SESSION_LIFETIME = 30 * 60; // in secunde 

function require_role(bool $is_admin_required)
{
    // verifica daca utilizatorul este autentificat
    if (!isset($_SESSION['user']['is_admin'])) {
        redirect_to('../pagini/auth.php');
    }

    // verifica rolul utilizatorului
    if ($is_admin_required && $_SESSION['user']['is_admin'] === false) {
        // acces refuzat pentru utilizatori obisnuiti
        redirect_to('../pagini/access_denied.php');
    }

    if (!$is_admin_required && $_SESSION['user']['is_admin'] === true) {
        // acces refuzat pentru administratori
        redirect_to('../pagini/access_denied.php');
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
