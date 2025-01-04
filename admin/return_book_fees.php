<?php
require_once __DIR__ . '/../lib/common.php';

const BORROWED_BOOKS_LIMIT = 5;
const LENDING_DAYS = 14;
const PENALTY_PER_DAY = 1.50;
$success = [];
$alerts = [];
$errors = [];
$books = [];
$books_fees = [];
$books_count = 0;


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
        $_SESSION['borrowing_user'] = $user;

        $books = get_borrowed_books_by_user($user['id']);
        $books_count = sizeof($books);

        //informare despre numarul de carti imprumutate
        if (empty($_SESSION['alerts']['borrowed_books_count'])) {
            $alerts['borrowed_books_count'] = "Utilizatorul are imprumutate " . $books_count . " carti. Mai poate imprumuta inca " . BORROWED_BOOKS_LIMIT - $books_count . " carti.";
        }
        $_SESSION['borrowing_user']['borrowed_count'] = $books_count;


        //penalitati de intarziere
        $current_date = new DateTime('now', new DateTimeZone('Europe/Bucharest'));

        foreach ($books as $book) {
            $due_date = new DateTime($book['due_date'], new DateTimeZone('Europe/Bucharest'));
            $interval = $due_date->diff($current_date);
            $days_late = ($current_date > $due_date) ? $interval->days : 0;
            $fee = $days_late * PENALTY_PER_DAY;

            $existing_fee = get_fee_by_user_and_book($user['id'], $book['book_id']);

            if (!empty($existing_fee)) {
                //actualizare taxa
                $existing_fee = $existing_fee[0]['late_fee'];

                if (!update_fee($fee, $user['id'], $book['book_id'])) {
                    $errors['late_fee_update'] = "Actualizarea penalitatilor de intarziere nu s-a putut realiza.";
                }
            } else {
                //inserare taxa noua daca s-a produs depasirea scadentei
                if ($fee > 0) {
                    if (!insert_fee($fee, $user['id'], $book['book_id'])) {
                        $errors['late_fee_insert'] = "Adaugarea penalitatilor de intarziere nu s-a putut realiza.";
                    }
                }
            }

            $books_fees[] = [
                'book_id' => $book['book_id'],
                'title' => $book['title'],
                'isbn' => $book['isbn'],
                'authors' => $book['authors'],
                'due_date' => $book['due_date'],
                'days_late' => $days_late,
                'late_fee' => $fee
            ];
        }

        //gaseste datorii
        $late_fee_query = "SELECT NVL(SUM(late_fee), 0) AS total_fee FROM users_fees WHERE user_id = ?";
        $total_late_fee = execute_query_and_fetch($late_fee_query, 'i', [$user['id']])[0]['total_fee'];
        if (empty($total_late_fee)) {
            $errors['total_late_fee'] = "Suma totala a penalitatilor de intarziere nu a putut fi calculata.";
        }
    }
}

// if (is_post_req() && isset($_POST['lendBook'])) {
//     $user = $_SESSION['borrowing_user'];
//     $book_ids = $_POST['book_ids'] ?? [];

//     if (empty($user)) {
//         $errors['user_required'] = "Nu este selectat niciun utilizator.";
//     }

//     if (empty($book_ids)) {
//         $errors['book_ids'] = "Te rog sa selectezi cel putin o carte.";
//     }
//     $borrowed_count = $user['borrowed_count'];
//     foreach ($book_ids as $book_id) {
//         if ($borrowed_count >= BORROWED_BOOKS_LIMIT) {
//             $errors['borrow_limit'] = "Limita de " . BORROWED_BOOKS_LIMIT . " carti imprumutate a fost atinsa. Nu pot fi imprumutate mai multe carti.";
//             break;
//         }

//         //verificam daca utilizatorul are deja imprumutata cartea
//         $borrowed_book = execute_query_and_fetch("SELECT COUNT(*) as cnt FROM borrowed_books WHERE book_id = ? AND user_id = ? AND status = 'borrowed'", "ii", [$book_id, $user['id']])[0]['cnt'];
//         if ($borrowed_book !== 0) {
//             $errors['already_borrowed'] = "Utilizatorul a imprumutat deja cartea.";
//         }

//         if (empty($errors)) {

//             // acordare imprumut/imprumuturi
//             $insert_query = "INSERT INTO borrowed_books(book_id, user_id, due_date) VALUES(?, ?, DATE_ADD(NOW(), INTERVAL " . LENDING_DAYS . " DAY))";

//             if (execute_query($insert_query, "ii", [$book_id, $user['id']])) {

//                 $update_no_of_copies_query = "UPDATE books SET no_of_copies = no_of_copies - 1 WHERE id = ?";

//                 if (!execute_query($update_no_of_copies_query, "i", [$book_id])) {
//                     $errors['update_no_of_copies'] = "Nu s-a putut modifica numarul de exemplare.";
//                 }

//                 $borrowed_count++;
//             } else {
//                 $errors['lending_book'] = "Nu s-a putut acorda imprumutul.";
//             }
//         }
//     }

//     if (empty($errors)) {
//         $success['borrow_success'] = "Imprumutul a fost acordat cu succes utilizatorului cu permis numarul " . $user['card_no'] . " si email " . $user['email'] . ".";
//         $_SESSION['success'] = $success;
//     }
// }

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

include __DIR__ . '/../pagini/return_book.php';
// include __DIR__ . '/../fragmente/return_book_form.php';
