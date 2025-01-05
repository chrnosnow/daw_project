<?php

require_once __DIR__ . '/../lib/common.php';

// Configurare paginatie
$results_per_page = 5;
$current_page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($current_page - 1) * $results_per_page;

// Obtinem litera selectată din URL
$selected_letter = $_GET['letter'] ?? '';

//Construim clauza WHERE
$where_clause = '';
$params = [];
$types = '';

$where_clause_letter = '';
if (!empty($selected_letter) && preg_match('/^[A-Za-z]$/', $selected_letter)) {
    $where_clause_letter = "book_list.title LIKE ?";
    $params[] = $selected_letter . '%';
    $types .= 's';
}

$search_term = $_GET['search'] ?? '';
$where_clause_search = '';
if (!empty($search_term)) {
    $search_term_sql = "%$search_term%";
    $where_clause_search = "UPPER(book_list.title) LIKE UPPER(?)
                        OR UPPER(book_list.isbn) LIKE UPPER(?)
                        OR UPPER(book_list.authors) LIKE UPPER(?)
                        ";
    for ($i = 0; $i < 3; $i++) {
        $params[] = $search_term_sql;
        $types .= 's';
    }
}

if (!empty($selected_letter) && !empty($search_term)) {
    $where_clause .= "WHERE $where_clause_letter AND $where_clause_search";
} else if (!empty($selected_letter)) {
    $where_clause .= "WHERE $where_clause_letter";
} else if (!empty($search_term)) {
    $where_clause .= "WHERE $where_clause_search";
}

// Obtinem numarul total de carti filtrate
$book_list_subquery = "
    SELECT borrowed_books.id as borrowing_id, borrowed_books.book_id as book_id, books.title, books.isbn, 
        GROUP_CONCAT(CONCAT(authors.first_name, ' ', authors.last_name) SEPARATOR ', ') AS authors, borrowed_books.user_id, borrowed_books.borrowed_at, borrowed_books.returned_at, users.email, users.card_no
    FROM borrowed_books
    LEFT JOIN books ON books.id = borrowed_books.book_id
    LEFT JOIN author_book ON books.id = author_book.book_id
    LEFT JOIN authors ON authors.id = author_book.author_id
    LEFT JOIN users ON borrowed_books.user_id = users.id
    WHERE borrowed_books.status = 'returned'
    GROUP BY borrowed_books.id, borrowed_books.user_id
    ORDER BY borrowed_books.returned_at DESC, books.title ASC 
";
$total_books_query = "
    SELECT COUNT(*) AS total 
    FROM ($book_list_subquery) AS book_list
    $where_clause
";
$total_books = execute_query_and_fetch($total_books_query, $types, $params)[0]['total'];
$total_pages = ceil($total_books / $results_per_page);

//Obtinem pagina curenta a listei de carti filtrare
$query = "
    SELECT *  
    FROM ($book_list_subquery) AS book_list
    $where_clause
    LIMIT ? OFFSET ?
";
$params[] = $results_per_page;
$params[] = $offset;
$types .= 'ii';

$result = execute_query_and_fetch($query, $types, $params);

include __DIR__ . "/../fragmente/return_history_form.php";
