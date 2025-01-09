<?php
define('ALLOWED_ACCESS', true);
require_once __DIR__ . '/../pagini/common.php';

require_role(['admin']);

// verifica daca timpul sesiunii a expirat
check_session_expiry();
// actualizeaza ultima activitate
$_SESSION['last_activity'] = time();


$success = [];
$errors = [];
if (is_get_req() && isset($_GET['id'])) {
    $book_id = $_GET['id'];

    if (!empty($book_id)) {
        if (empty(get_book_by_id($book_id))) {
            $errors['book_not_found'] = "Cartea nu a fost gasita.";
        }
    } else {
        $errors['book_id'] = "Identificatorul cartii nu este valid.";
    }

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
} else {
    redirect_to('../pagini/access_denied.php');
}
