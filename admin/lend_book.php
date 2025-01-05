<?php
require_once __DIR__ . '/../lib/common.php';

$success = [];
$alerts = [];
$errors = [];
const BORROWED_BOOKS_LIMIT = 5;
const LENDING_DAYS = 14;


if (is_post_req() && isset($_POST['lendUser'])) {

    //verify if user meets conditions for borrowing a book
    $user_email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);;
    $user_library_card = sanitize_text($_POST['library_card']);

    if (empty($user_email) || empty($user_library_card)) {
        $errors['all_required'] = DEFAULT_VALIDATION_ERRORS['all_required'];
    }

    if (!validate_email($user_email)) {
        $errors['valid_email'] = sprintf(DEFAULT_VALIDATION_ERRORS['email'], $email);
    }

    if (!validate_card_no($user_library_card)) {
        $errors['valid_card_no'] = sprintf(DEFAULT_VALIDATION_ERRORS['card_no'], $user_library_card);
    }

    $user_query = "SELECT id, email, card_no FROM users WHERE email = ? AND card_no = ? AND active = 1";
    $user = execute_query_and_fetch($user_query, "ss", [$user_email, $user_library_card]);

    if (empty($user)) {
        $errors['invalid_user'] = "Utilizatorul nu a fost gasit.";
    } else {
        $user = $user[0];
        $_SESSION['borrowing_user'] = $user;

        // get $books, $books_count, $books_fees, $total_late_fee
        $summary_errors = get_user_summary($user['id']);
        $errors = array_merge($errors, $summary_errors);

        //verificare limita carti imprumutate
        if ($books_count >= BORROWED_BOOKS_LIMIT) {
            $errors['borrow_limit'] = "Utilizatorul a atins deja limita de " . BORROWED_BOOKS_LIMIT . " carti imprumutate.";
        } else {
            $alerts['borrowed_books_count'] = "Utilizatorul are imprumutate " . $$books_count . " carti. Mai poate imprumuta inca " . BORROWED_BOOKS_LIMIT - $books_count . " carti.";
        }

        //verificare datorii
        if ($total_late_fee > 0) {
            $errors['late_fee'] = 'Utilizatorul are datorii in valoare de ' . number_format($total_late_fee, 2) . ' lei.';
        } else {
            $alerts['no_fees'] = 'Utilizatorul nu are datorii.';
            $_SESSION['borrowing_user']['late_fee'] = $total_late_fee;
        }

        if (!empty($alerts)) {
            $_SESSION['alerts'] = $alerts;
        }
    }
}

if (is_post_req() && isset($_POST['lendBook'])) {
    $user = $_SESSION['borrowing_user'];
    $book_ids = $_POST['book_ids'] ?? [];

    if (empty($user)) {
        $errors['user_required'] = "Nu este selectat niciun utilizator.";
    }

    if (empty($book_ids)) {
        $errors['book_ids'] = "Te rog sa selectezi cel putin o carte.";
    }
    $borrowed_count = $user['borrowed_count'];
    foreach ($book_ids as $book_id) {
        if ($borrowed_count >= BORROWED_BOOKS_LIMIT) {
            $errors['borrow_limit'] = "Limita de " . BORROWED_BOOKS_LIMIT . " carti imprumutate a fost atinsa. Nu pot fi imprumutate mai multe carti.";
            break;
        }

        //verificam daca utilizatorul are deja imprumutata cartea
        $borrowed_book = execute_query_and_fetch("SELECT COUNT(*) as cnt FROM borrowed_books WHERE book_id = ? AND user_id = ? AND status = 'borrowed'", "ii", [$book_id, $user['id']])[0]['cnt'];
        if ($borrowed_book !== 0) {
            $errors['already_borrowed'] = "Utilizatorul a imprumutat deja cartea.";
        }

        if (empty($errors)) {

            // acordare imprumut/imprumuturi
            $insert_query = "INSERT INTO borrowed_books(book_id, user_id, due_date) VALUES(?, ?, DATE_ADD(NOW(), INTERVAL " . LENDING_DAYS . " DAY))";

            if (execute_query($insert_query, "ii", [$book_id, $user['id']])) {

                $update_no_of_copies_query = "UPDATE books SET no_of_copies = no_of_copies - 1 WHERE id = ?";

                if (!execute_query($update_no_of_copies_query, "i", [$book_id])) {
                    $errors['update_no_of_copies'] = "Nu s-a putut modifica numarul de exemplare.";
                }

                $_SESSION['borrowing_user']['borrowed_count'] = $borrowed_count++;
            } else {
                $errors['lending_book'] = "Nu s-a putut acorda imprumutul.";
            }
        }
    }

    if (empty($errors)) {
        $success['borrow_success'] = "Imprumutul a fost acordat cu succes utilizatorului cu permis numarul " . $user['card_no'] . " si email " . $user['email'] . ".";
        $_SESSION['success'] = $success;
    }
}

if (is_post_req() && isset($_POST['lendCancel'])) {
    unset($_SESSION['borrowing_user']);
    redirect_to('../pagini/borrow_book.php');
}

if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
}

redirect_to('../pagini/borrow_book.php');
