<?php
require_once __DIR__ . '/../config/database.php';

function add_book(string $title, string $edition = '', string $isbn, string $publisher, string $year = '', $language = "Romana")
{
    if (empty($title) || empty($isbn)) {
        return false;
    }

    return execute_query(
        "INSERT INTO books(title, edition, isbn, publisher, publication_year, language) VALUES (?, ?, ?, ?, ?, ?)",
        "ssssis",
        [$title, $edition, $isbn, $publisher, $year, $language]
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
