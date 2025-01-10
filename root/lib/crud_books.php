<?php
require_once __DIR__ . '/../config/database.php';

function add_book(string $title, string $edition, string $isbn, string $publisher, string $year, $language = "Romana", $no_of_copies)
{
    if (empty($title) || empty($isbn)) {
        return false;
    }

    return execute_query(
        "INSERT INTO books(title, edition, isbn, publisher, publication_year, language, no_of_copies) VALUES (?, ?, ?, ?, ?, ?, ?)",
        "ssssisi",
        [$title, $edition, $isbn, $publisher, $year, $language, $no_of_copies]
    );
}

function add_author(string $last_name, string $first_name = '')
{
    if (empty($last_name)) {
        return false;
    }
    return execute_query(
        "INSERT INTO authors(first_name, last_name) VALUES (?, ?)",
        "ss",
        [$first_name, $last_name]
    );
}

function get_author(string $last_name, string $first_name = '')
{
    if (empty($last_name)) {
        return false;
    }

    return execute_query_and_fetch(
        "SELECT id FROM authors WHERE UPPER(first_name) = UPPER(?) AND UPPER(last_name) = UPPER(?)",
        "ss",
        [$first_name, $last_name]
    );
}

function add_authors_to_book($author_id, $book_id)
{
    if (empty($author_id) || empty($book_id)) {
        return false;
    }

    return execute_query(
        "INSERT INTO author_book(author_id, book_id) VALUES (?, ?)",
        "ii",
        [$author_id, $book_id]
    );
}

function get_all_books()
{
    $query = "
         SELECT books.id AS book_id, books.title, books.isbn, 
            GROUP_CONCAT(CONCAT(authors.first_name, ' ', authors.last_name) SEPARATOR ', ') AS authors, books.no_of_copies
        FROM books
        LEFT JOIN author_book ON books.id = author_book.book_id
        LEFT JOIN authors ON authors.id = author_book.author_id
        GROUP BY books.id
        ORDER BY books.title;
    ";
    return execute_query_and_fetch($query);
}

function get_book_by_id(int $book_id)
{
    $query = "SELECT books.id AS book_id, books.title, books.isbn, books.publisher, books.publication_year, books.language, books.edition, books.created_at, books.updated_at,GROUP_CONCAT(CONCAT(authors.first_name, ' ', authors.last_name) SEPARATOR ', ') AS authors, books.no_of_copies
    FROM books
    LEFT JOIN author_book ON books.id = author_book.book_id
    LEFT JOIN authors ON authors.id = author_book.author_id
    WHERE books.id = ?
    GROUP BY books.id";
    return execute_query_and_fetch($query, "i", [$book_id]);
}

function get_book_by_title_and_isbn(string $title, string $isbn)
{
    $query = "
        SELECT books.id AS book_id, books.title, books.isbn, books.publisher, books.publication_year, books.language, books.edition, books.created_at, books.updated_at,
            GROUP_CONCAT(CONCAT(authors.first_name, ' ', authors.last_name) SEPARATOR ', ') AS authors, books.no_of_copies
        FROM books
        LEFT JOIN author_book ON books.id = author_book.book_id
        LEFT JOIN authors ON authors.id = author_book.author_id
        WHERE books.title = ? AND books.isbn = ?
        GROUP BY books.id
    ";
    return execute_query_and_fetch($query, "ss", [$title, $isbn]);
}

function update_book($book_id, $title, $isbn, $publisher = '', $publication_year = '', $language = 'Romana', $edition = '')
{
    $update_query = "UPDATE books SET title = ?, isbn = ?, publisher = ?, publication_year = ?, language = ?, edition = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?";
    return execute_query($update_query, "ssssssi", [
        $title,
        $isbn,
        $publisher,
        $publication_year,
        $language,
        $edition,
        $book_id
    ]);
}

function delete_authors_from_book(int $book_id)
{
    return execute_query("DELETE FROM author_book WHERE book_id = ?", "i", [$book_id]);
}

function delete_book(int $book_id)
{
    return execute_query("DELETE FROM books WHERE id = ?", "i", [$book_id]);
}
