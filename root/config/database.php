<?php

const DB_HOST = 'localhost';
const DB_USER = 'root';
const DB_PASS = '';
const DB_NAME = 'daw_project';

function db(): mysqli
{
    static $conn;
    if (!$conn) {
        @$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    }
    // echo is_null($conn) ? "conn is null\n" : "conn is not null\n";
    // echo var_dump($conn);
    return $conn;
}

if (mysqli_connect_errno()) {
    exit('Nu s-a putut realiza conexiunea la baza de date: ' . mysqli_connect_error());
}
