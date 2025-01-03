<?php
require_once __DIR__ . '/../lib/common.php';
// include_once __DIR__ . '/book_info.php';

$success = [];
$errors = [];

//delete author-book relation
if (!delete_authors_from_book($book_id)) {
    $errors['delete_author_from_book'] = 'A aparut o eroare la stergerea autorului.';
}
//delete book
if (!delete_book($book_id)) {
    $errors['delete_book'] = 'A aparut o eroare la stergerea cartii.';
}
$_SESSION['errors'] = $errors;

$success['delete_book'] = 'Cartea a fost stearsa cu succes.';
$_SESSION['success'] = $success;

redirect_to('../pagini/manage_book.php');
