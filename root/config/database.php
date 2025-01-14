<?php

const DB_HOST = 'localhost';
const DB_USER = 'root';
const DB_PASS = '';
const DB_NAME = 'daw_project';

// define('DB_HOST', getenv('MYSQLHOST'));
// define('DB_USER', getenv('MYSQLUSER'));
// define('DB_PASS', getenv('MYSQLPASSWORD'));
// define('DB_NAME', getenv('MYSQLDATABASE'));
// echo 'getenv("MYSQLHOST"): ' . DB_HOST . ', ' . DB_USER;

function db(): mysqli
{
    static $conn;
    if (!$conn) {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    }

    return $conn;
}

if (mysqli_connect_errno()) {
    exit('Nu s-a putut realiza conexiunea la baza de date: ' . mysqli_connect_error());
}
