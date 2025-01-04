<?php
require_once __DIR__ . '/../config/database.php';

function get_borrowed_books_by_user(int $user_id)
{
    if (empty($user_id)) {
        return false;
    }

    $borrowed_books_query = "
            SELECT borrowed_books.book_id as book_id, books.title, books.isbn, 
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
