<?php
require_once __DIR__ . '/../lib/common.php';

$action = '';
$success = [];
$errors = [];


// echo "akdfsjsdnfhi rlfioeargkjsfbdvjksfv";

// if (!empty($_GET['action'])) {

// $action = sanitize_text($_GET['action']);

// if ($action === 'create' && is_post_req()) {
$title = sanitize_text($_POST['title']);
$edition = sanitize_text($_POST['edition']) ?? '';
$isbn = sanitize_text($_POST['isbn']);
$publisher = sanitize_text($_POST['publisher']) ?? '';
$year = $_POST['public_yr'] ?? '';
$language = sanitize_text($_POST['lang']) ?? '';
$author_ids = $_POST['author_ids'] ?? [];
$new_authors = $_POST['new_authors'] ?? [];

if (empty($title) || empty($isbn) || (empty($author_ids) && empty($new_authors))) {
    $errors['add_book_all_req'] = DEFAULT_VALIDATION_ERRORS['all_required'];
}

if (!validate_isbn_format($isbn)) {
    $errors['isbn_format'] = "ISBN invalid.";
}

if (!validate_integer($publication_year) || strlen($publication_year) != 4) {
    $errors['publication_year'] = "Anul de publicatie este invalid.";
}

// introducem cartea in baza de date
$book_added = add_book($title, $edition, $isbn, $publisher, $year, $language);
if ($book_added) {
    $book_id = db()->insert_id;
} else {
    $errors['book_not_added'] = "Nu s-a putut realiza adaugarea cartii in baza de date.";
}

//introducem autorii noi in baza de date
if (!empty($new_authors)) {
    $new_authors_list = explode(',', $new_authors);
    foreach ($new_authors_list as $author_name) {
        $author_name = sanitize_text($author_name);
        if (strpos($author_name, ' ') === false) {
            $last_name = $author_name;
            $existing_author = get_author($last_name);
            if ($existing_author) {
                $author_ids[] = $existing_author[0]['id']; // Adauga ID-ul autorului existent
            } elseif (add_author($last_name)) {
                $author_ids[] = db()->insert_id;
            } else {
                $errors['add_author'] = DEFAULT_VALIDATION_ERRORS['add_author'];
            }
        }

        $name_parts = explode(' ', $author_name);
        // Ultimul element trebuie sa fie numele de familie
        $last_name = array_pop($name_parts);
        $first_name = implode(' ', $name_parts);
        $existing_author = get_author($last_name, $first_name);
        if ($existing_author) {
            $author_ids[] = $existing_author[0]['id']; // Adauga ID-ul autorului existent
        } else {
            if (add_author($last_name, $first_name)) {
                $author_ids[] = db()->insert_id;
            } else {
                $errors['add_author'] = DEFAULT_VALIDATION_ERRORS['add_author'];
            }
        }
    }
}

// Asociem autorii cu cartea
foreach ($author_ids as $author_id) {
    if (!add_authors_to_book($author_id, $book_id)) {
        $errors['add_author_to_book'] = DEFAULT_VALIDATION_ERRORS['add_author_to_book'];
    }
}


if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    redirect_to('../pagini/manage_book.php');
}

$success['book_success'] = "Adaugarea cartii noi s-a realizat cu succes.";
$_SESSION['success'] = $success;


// include '../fragmente/book_form.php';
redirect_to('../pagini/manage_book.php');
// }
// }
