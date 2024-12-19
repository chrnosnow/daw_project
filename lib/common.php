<?php

session_start();

if (isset($_SESSION['errors'])) {
    $errors = $_SESSION['errors'];
}

require_once __DIR__ . '/../config/mail_config.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/validation.php';
require_once __DIR__ . '/errors.php';
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/mail.php';
require_once __DIR__ . '/crud_books.php';
