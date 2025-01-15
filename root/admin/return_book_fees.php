<?php
require_once __DIR__ . '/../lib/common.php';

const BORROWED_BOOKS_LIMIT = 5;
const LENDING_DAYS = 14;

$success = [];
$alerts = [];
$errors = [];

if (is_post_req() && isset($_POST['refreshUser'])) {
    $user = $_SESSION['borrowing_user'];
    $summary_errors = get_user_summary($user['id']);
    $user['late_fee'] = $total_late_fee;
    $user['borrowed_count'] = $books_count;
    $user['books_fees'] = $books_fees;
    $_SESSION['borrowing_user'] = $user;
    $errors = array_merge($errors, $summary_errors);
}

if (is_post_req() && isset($_POST['returnUser'])) {

    //get user
    $user_email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);;
    $user_library_card = sanitize_text($_POST['library_card']);

    if (empty($user_email) && empty($user_library_card)) {
        $errors['required'] = sprintf(DEFAULT_VALIDATION_ERRORS['required'], 'Emailul sau numarul permisului de biblioteca');
    }

    if (!empty($user_email) && !validate_email($user_email)) {
        $errors['valid_email'] = sprintf(DEFAULT_VALIDATION_ERRORS['email'], $email);
    }

    if (!empty($user_library_card) && !validate_card_no($user_library_card)) {
        $errors['valid_card_no'] = sprintf(DEFAULT_VALIDATION_ERRORS['card_no'], $user_library_card);
    }

    $user_query = "SELECT id, email, card_no FROM users WHERE email = ? OR card_no = ? AND active = 1";
    $user = execute_query_and_fetch($user_query, "ss", [$user_email, $user_library_card]);

    if (empty($user)) {
        $errors['invalid_user'] = "Utilizatorul nu a fost gasit.";
    } else {
        $user = $user[0];
        $summary_errors = get_user_summary($user['id']);
        $user['late_fee'] = $total_late_fee;
        $user['borrowed_count'] = $books_count;
        $user['books_fees'] = $books_fees;
        $_SESSION['borrowing_user'] = $user;
        $errors = array_merge($errors, $summary_errors);
    }
}

if (is_post_req() && isset($_POST['returnBook'])) {
    $user = $_SESSION['borrowing_user'];
    $books_ids = $_POST['books_ids'] ?? [];

    if (empty($user)) {
        $errors['user_required'] = "Nu este selectat niciun utilizator.";
    }

    if (!empty($books_ids)) {
        foreach ($books_ids as $book_id) {

            if (!update_borrowed_book_status_and_return_date($user['id'], $book_id)) {

                $errors['update_book_status'] = "A aparut o eroare la actualizarea statusului cartii de returnat.";
            }

            if (!update_book_no_of_copies($book_id)) {
                $errors['update_book_copies'] = "A aparut o eroare la actualizarea numarului de exemplare a cartii de returnat.";
            }

            if (!update_paid_fee_status($user['id'], $book_id)) {
                $errors['update_paid_fee'] = "A aparut o eroare la actualizarea statusului penalitatii platite.";
            }
        }
    } else {
        $errors['book_ids'] = "Te rog sa selectezi cel putin o carte.";
    }

    if (empty($errors)) {
        $success['borrow_success'] = "Cartile selectate au fost returnate cu succes.";
        $_SESSION['success'] = $success;
        //reactualizare a listei de carti si a penalitatilor de intarziere
        $summary_errors = get_user_summary($user['id']);
        $user['late_fee'] = $total_late_fee;
        $user['borrowed_count'] = $books_count;
        $user['books_fees'] = $books_fees;
        $_SESSION['borrowing_user'] = $user;
        $errors = array_merge($errors, $summary_errors);
    }
}

if (is_post_req() && isset($_POST['returnCancel'])) {
    unset($_SESSION['borrowing_user']);
    redirect_to('../pagini/return_book.php');
}

if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
}

if (!empty($alerts)) {
    $_SESSION['alerts'] = $alerts;
}

redirect_to('../pagini/return_book.php');
