<?php
require_once __DIR__ . '/../config/database.php';

const PENALTY_PER_DAY = 1.50;

/**
 * Summary of get_user_summary
 * @param int $user_id
 * @return array - the list of errors
 * 
 * This function provides information about list of borrowed books, its count and 
 * current penalties for late return of borrowed books.
 */
function get_user_summary(int $user_id)
{
    global $books, $books_count, $books_fees, $total_late_fee;
    $errors = [];

    //list of borrowed books
    $books = get_borrowed_books_by_user($user_id);
    if ($books === false) {
        $errors['borrowed_books'] = "Nu s-a putut obtine lista de carti imprumutate.";
    }

    $books_count = sizeof($books ?? []);
    $_SESSION['borrowing_user']['borrowed_count'] = $books_count;

    //late return penalties
    $current_date = new DateTime('now', new DateTimeZone('Europe/Bucharest'));
    $books_fees = [];

    foreach ($books as $book) {
        try {
            $due_date = new DateTime($book['due_date'], new DateTimeZone('Europe/Bucharest'));
        } catch (Exception $e) {
            $errors['date_error'] = "Data scadentei nu este valida pentru cartea {$book['title']}.";
            continue;
        }

        $interval = $due_date->diff($current_date);
        $days_late = ($current_date > $due_date) ? $interval->days : 0;

        $fee = $days_late * PENALTY_PER_DAY;

        $existing_fee = get_fee_by_user_and_book($user_id, $book['book_id']);
        if (!empty($existing_fee)) {
            //update existing penalty 
            $existing_fee = $existing_fee[0]['late_fee'];

            if (!update_fee($fee, $user_id, $book['book_id'])) {
                $errors['late_fee_update'] = "Actualizarea penalitatilor de intarziere nu s-a putut realiza.";
            }
        } else {
            //insert new penalty
            if ($fee > 0) {
                if (!insert_fee($fee, $user_id, $book['book_id'])) {
                    $errors['late_fee_insert'] = "Adaugarea penalitatilor de intarziere nu s-a putut realiza.";
                }
            }
        }

        //list of borrowed books and penalty details used to display to front-end
        $books_fees[] = [
            'borrowing_id' => $book['borrowing_id'],
            'book_id' => $book['book_id'],
            'title' => $book['title'],
            'isbn' => $book['isbn'],
            'authors' => $book['authors'],
            'due_date' => $book['due_date'],
            'days_late' => $days_late,
            'late_fee' => $fee
        ];
    }

    //total sum of penalties for the user
    $total_late_fee = get_total_fee_by_user($user_id);
    if ($total_late_fee === false) {
        $errors['total_late_fee'] = "Suma totala a penalitatilor de intarziere nu a putut fi calculata.";
    } else {
        $total_late_fee = $total_late_fee[0]['total_fee'];
        $_SESSION['borrowing_user']['late_fee'] = $total_late_fee;
    }

    return $errors;
}

function get_borrowed_books_by_user(int $user_id)
{
    if (empty($user_id)) {
        return false;
    }

    $borrowed_books_query = "
        SELECT borrowed_books.id as borrowing_id, borrowed_books.book_id as book_id, books.title, books.isbn, 
            GROUP_CONCAT(CONCAT(authors.first_name, ' ', authors.last_name) SEPARATOR ', ') AS authors, borrowed_books.user_id, borrowed_books.borrowed_at, borrowed_books.due_date
        FROM borrowed_books
        LEFT JOIN books ON books.id = borrowed_books.book_id
        LEFT JOIN author_book ON books.id = author_book.book_id
        LEFT JOIN authors ON authors.id = author_book.author_id
        LEFT JOIN users ON borrowed_books.user_id = users.id
        WHERE borrowed_books.status = 'borrowed' AND borrowed_books.user_id = ?
        GROUP BY borrowed_books.book_id
        ORDER BY books.title ASC
    ";
    return execute_query_and_fetch($borrowed_books_query, 'i', [$user_id]);
}

function get_fee_by_user_and_book(int $user_id, int $book_id)
{
    if (empty($user_id) || empty($book_id)) {
        return false;
    }

    $fee_check_query = "
        SELECT id as fee_id, late_fee 
        FROM users_fees 
        WHERE user_id = ? AND book_id = ?
    ";
    return execute_query_and_fetch($fee_check_query, 'ii', [$user_id, $book_id]);
}

function update_fee(float $fee, int $user_id, int $book_id)
{
    $update_fee_query = "
        UPDATE users_fees
        SET late_fee = ?
        WHERE user_id = ? AND book_id = ?
    ";
    return execute_query($update_fee_query, 'dii', [$fee, $user_id, $book_id]);
}

function insert_fee(float $fee, int $user_id, int $book_id)
{
    $insert_fee_query = "
        INSERT INTO users_fees (user_id, book_id, late_fee)
        VALUES (?, ?, ?)
    ";
    return execute_query($insert_fee_query, 'iid', [$user_id, $book_id, $fee]);
}

function get_total_fee_by_user(int $user_id)
{
    $late_fee_query = "
        SELECT NVL(SUM(late_fee), 0) AS total_fee 
        FROM users_fees 
        WHERE user_id = ? AND payment_status = 'not paid'
    ";
    return execute_query_and_fetch($late_fee_query, 'i', [$user_id]);
}

function update_paid_fee_status(int $user_id, int $book_id)
{
    $update_query = "
        UPDATE users_fees
        SET payment_status = 'paid', updated_at = NOW()
        WHERE user_id = ? AND book_id = ? AND payment_status = 'not paid'
    ";

    return execute_query($update_query, 'ii', [$user_id, $book_id]);
}

function update_borrowed_book_status_and_return_date(int $user_id, int $book_id)
{
    $update_query = "
        UPDATE borrowed_books
        SET status = 'returned', returned_at = NOW()
        WHERE user_id = ? AND book_id = ?
    ";
    return execute_query($update_query, 'ii', [$user_id, $book_id]);
}

function update_book_no_of_copies(int $book_id)
{
    $update_query = "
        UPDATE books 
        SET no_of_copies = no_of_copies + 1
        WHERE id = ?
    ";
    return execute_query($update_query, 'i', [$book_id]);
}


// function update_all_late_fees_amount(){
//     $update_query = "
//         UPDATE
//     ";
// }