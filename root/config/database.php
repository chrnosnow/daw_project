<?php

// const DB_HOST = 'localhost';
// const DB_USER = 'root';
// const DB_PASS = '';
// const DB_NAME = 'daw_project';

const DB_HOST = getenv('MYSQLHOST');
const DB_USER = getenv('MYSQLUSER');
const DB_PASS = getenv('MYSQLPASSWORD');
const DB_NAME = getenv('MYSQLDATABASE');

function db(): mysqli
{
    static $conn;
    if (!$conn) {
        @$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    }

    return $conn;
}

if (mysqli_connect_errno()) {
    exit('Nu s-a putut realiza conexiunea la baza de date: ' . mysqli_connect_error());
}
