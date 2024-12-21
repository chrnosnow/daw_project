<?php
require_once __DIR__ . '/../lib/common.php';

$book_id = $_GET['id'] ?? 0;
$book = null;
$errors = [];

if (!empty($book_id)) {
    $query = "
    SELECT books.id AS book_id, books.title, books.isbn, books.publisher, books.publication_year, books.language, books.edition, books.created_at, books.updated_at,
           GROUP_CONCAT(CONCAT(authors.first_name, ' ', authors.last_name) SEPARATOR ', ') AS authors
    FROM books
    LEFT JOIN author_book ON books.id = author_book.book_id
    LEFT JOIN authors ON authors.id = author_book.author_id
    WHERE books.id = ?
    GROUP BY books.id
";
    $res = execute_query_and_fetch($query, "i", [$book_id]);

    if (!empty($res)) {
        $book = $res[0];
    } else {
        $errors['book_not_found'] = "Cartea nu a fost gasita.";
    }
} else {
    $errors['book_id'] = "ID-ul cartii nu este valid.";
}

if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
}

// redirect_to('../pagini/book_display.php');
