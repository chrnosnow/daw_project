<?php
require_once __DIR__ . '/../pagini/common.php';


$success = [];
$errors = [];

if (is_post_req() && isset($_POST['saveBook'])) {

    $title = sanitize_text($_POST['title']);
    $edition = sanitize_text($_POST['edition']) ?? '';
    $isbn = sanitize_text($_POST['isbn']);
    $publisher = sanitize_text($_POST['publisher']) ?? '';
    $year = $_POST['public_yr'];
    $language = sanitize_text($_POST['lang']) ?? '';
    $author_ids = $_POST['author_ids'] ?? [];
    $new_authors = $_POST['new_authors'] ?? [];
    $no_of_copies = empty($_POST['no_of_copies']) ? 0 : $_POST['no_of_copies'];

    if (empty($title) || empty($isbn) || (empty($author_ids) && empty($new_authors))) {
        $errors['add_book_all_req'] = DEFAULT_VALIDATION_ERRORS['all_required'];
    }

    if (!validate_isbn_format($isbn)) {
        $errors['isbn_format'] = "ISBN invalid.";
    }

    if (!validate_integer($year) || strlen($year) != 4 || (int) $year > date('Y') || (int)$year < 0) {
        $errors['publication_year'] = "Anul de publicatie este invalid.";
    }

    if (!validate_integer($no_of_copies) || (int)$no_of_copies < 0) {
        $errors['no_of_copies'] = "Numarul de exemplare este invalid.";
    }

    if (empty($errors)) {
        //verificam daca exista cartea, dupa titlu si isbn
        $existing_book = get_book_by_title_and_isbn($title, $isbn);
        if (empty($existing_book)) {
            // introducem cartea in baza de date
            $book_added = add_book($title, $edition, $isbn, $publisher, $year, $language, $no_of_copies);
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
        } else {
            $errors['exists_book'] = "Cartea deja exista in baza de date!";
        }
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        redirect_to('../pagini/add_book.php');
    }

    $success['book_success'] = "Adaugarea cartii noi s-a realizat cu succes.";
    $_SESSION['success'] = $success;
    $_POST = [];

    redirect_to('../pagini/book_details.php?id=' . $book_id);
}
