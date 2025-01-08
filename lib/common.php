<?php

session_start();

// Dezactiveaza cache-ul browserului
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP/1.1; Instruiește browserul să nu păstreze copia paginii în cache.
header("Pragma: no-cache"); // HTTP/1.0; Este pentru compatibilitate cu HTTP/1.0 și are același efect ca Cache-Control.
header("Expires: 0"); // Dezactivează cache-ul pentru proxy-uri; Setează timpul de expirare la o valoare trecută, astfel încât pagina să fie considerată deja expirată.


require_once __DIR__ . '/../config/mail_config.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/validation.php';
require_once __DIR__ . '/errors.php';
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/access_control.php';
require_once __DIR__ . '/mail.php';
require_once __DIR__ . '/crud_books.php';
require_once __DIR__ . '/borrowings.php';
require_once __DIR__ . '/crud_analytics.php';
require_once __DIR__ . '/../other/site_analytics.php';



//interzicere acces pentru fisiere care nu sunt publice
if (!defined('ALLOWED_ACCESS')) {
    if (empty($_SESSION['allow_processing']) && empty($_POST['token_processing'])) {
        redirect_to("../pagini/access_denied.php");
    }
}

// verificare pentru procesare valida
if (isset($_POST['token_processing'])) {
    if (empty($_SESSION['form_token']) || $_POST['token_processing'] !== $_SESSION['form_token']) {
        redirect_to("../pagini/access_denied.php");
    }
    // eliminam token-ul dupa utilizare pentru a preveni reutilizarea
    unset($_SESSION['form_token']);
}

// conditii pentru regenerarea ID-ului sesiunii
$should_regenerate = false;

// 1. Regenerare periodica
if (!isset($_SESSION['last_regeneration_time']) || time() - $_SESSION['last_regeneration_time'] > 15 * 60) {
    $should_regenerate = true;
}

// 2. Regenerare pentru actiuni sensibile (login, activare cont, schimbare parola)
if (
    isset($_POST['signin']) || isset($_POST['saveDetails']) ||
    isset($_GET['activation_code'])
) {
    $should_regenerate = true;
}

// regenerare ID sesiune
if ($should_regenerate) {
    if (session_id() !== '') {
        $_SESSION['previous_session_id'] = session_id();
    }

    session_regenerate_id(true);
    $_SESSION['last_regeneration_time'] = time();
}
