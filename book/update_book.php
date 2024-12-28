<?php
require_once __DIR__ . '/../lib/common.php';

$success = [];
$errors = [];

if (is_post_req() && isset($_POST['saveBook'])) {
    echo "sunt aici";
    $book_id = $_POST['book_id'];
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

    if (!validate_integer($public_yr) || strlen($public_yr) != 4) {
        $errors['book_publication_year'] = "Anul de publicatie este invalid.";
    }

    if (empty($errors)) {
        //update book
        if (!update_book($book_id, $title, $isbn, $publisher, $public_yr, $language, $edition)) {
            $errors['update_book'] = "Nu s-au putut actualiza detaliile despre carte.";
        }

        //update authors
        $author_names = array_map('trim', explode(',', $authors));
        //delete current author-book relations
        delete_authors_from_book($book_id);
        foreach ($author_names as $author_name) {
            $name_parts = explode(' ', $author_name, 2);
            $first_name = $name_parts[0] ?? '';
            $last_name = $name_parts[1] ?? '';

            // search or add author name
            // edge case - single name author
            $author_result = empty($last_name) ? $author_result = get_author($first_name) : $author_result = get_author($last_name, $first_name);

            if (empty($author_result)) {
                //add new author
                $res = empty($last_name) ? add_author($first_name) : add_author($last_name, $first_name);
                if ($res) {
                    $author_id = db()->insert_id;
                } else {
                    $errors['add_author'] = "Nu s-a putut adauga autorul in baza de date.";
                }
            } else {
                $author_id = $author_result[0]['id'];
            }

            //add author to book
            if (!add_authors_to_book($author_id, $book_id)) {
                $errors['update_author'] = "Nu s-au putut actualiza detaliile despre autori.";
            }
        }
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        redirect_to('../fragmente/book_details_admin.php?id=' . $book_id);
    }

    $success['update_book'] = "Detaliile despre carte au fost modificate cu succes.";
    $_SESSION['success'] = $success;
    redirect_to('../fragmente/book_details_admin.php?id=' . $book_id);
}
