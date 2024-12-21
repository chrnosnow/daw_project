<?php
require_once __DIR__ . '/../lib/common.php';

$book_id = $_GET['id'] ?? 0;
$book = null;
$errors = [];

if (!empty($book_id)) {

    $res = get_book_by_id($book_id);

    if (!empty($res)) {
        $book = $res[0];
    } else {
        $errors['book_not_found'] = "Cartea nu a fost gasita.";
    }
} else {
    $errors['book_id'] = "ID-ul cartii nu este valid.";
}

if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
}
