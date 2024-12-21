<?php
require_once __DIR__ . '/../lib/common.php';

$success = [];
$errors = [];

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

if (is_post_req() && isset($_POST['saveBook'])) {
    $title = sanitize_text($_POST['title']);
    $edition = sanitize_text($_POST['edition']) ?? '';
    $isbn = sanitize_text($_POST['isbn']);
    $publisher = sanitize_text($_POST['publisher']) ?? '';
    $public_yr = $_POST['public_yr'];
    $language = sanitize_text($_POST['lang']) ?? '';
    $authors = trim($_POST['authors']);

    if (empty($title) || empty($isbn) || empty($authors)) {
        $errors['update_book_required'] = sprintf(DEFAULT_VALIDATION_ERRORS['required'], "Campul *");
    }

    if (!validate_isbn_format($isbn)) {
        $errors['isbn_format'] = "ISBN invalid.";
    }

    if (!validate_integer($publication_year) || strlen($publication_year) != 4) {
        $errors['book_publication_year'] = "Anul de publicatie este invalid.";
    }

    if (empty($errors)) {
        //update book
        if (!update_book($book_id, $title, $isbn, $publisher, $publication_year, $language, $edition)) {
            $errors['update_book'] = "Nu s-au putut actualiza detaliile despre carte.";
        }
    }



    // Actualizează relația carte-autori
    // $author_names = array_map('trim', explode(',', $authors)); // Transformă în array
    // execute_query($connection, "DELETE FROM author_book WHERE book_id = ?", "i", [$book_id]); // Șterge relațiile vechi

    // foreach ($author_names as $author_name) {
    //     // Caută sau inserează autorul
    //     $author_query = "SELECT id FROM authors WHERE CONCAT(first_name, ' ', last_name) = ?";
    //     $author_result = execute_query_and_fetch($connection, $author_query, "s", [$author_name]);

    //     if (empty($author_result)) {
    //         // Autorul nu există, inserează
    //         $name_parts = explode(' ', $author_name, 2);
    //         $first_name = $name_parts[0] ?? '';
    //         $last_name = $name_parts[1] ?? '';
    //         $insert_author_query = "INSERT INTO authors (first_name, last_name) VALUES (?, ?)";
    //         execute_query($connection, $insert_author_query, "ss", [$first_name, $last_name]);

    //         $author_id = $connection->insert_id;
    //     } else {
    //         $author_id = $author_result[0]['id'];
    //     }

    //     // Adaugă relația în `author_book`
    //     $insert_relation_query = "INSERT INTO author_book (book_id, author_id) VALUES (?, ?)";
    //     execute_query($connection, $insert_relation_query, "ii", [$book_id, $author_id]);
    // }

    // // Redirecționează după salvare
    // header("Location: book_details.php?id=$book_id");
    // exit();
}

if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
}
