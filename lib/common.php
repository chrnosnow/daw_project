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

if (!defined('ALLOWED_ACCESS')) {
    redirect_to("../pagini/access_denied.php");
}
