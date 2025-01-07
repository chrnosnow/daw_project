<?php

require_once __DIR__ . '/../lib/common.php';

$action = $_GET['action'] ?? 'list';

if ($action === 'list') {

    // folosim paginatie pentru afisarea rezultatelor
    $books = [];
    $search_term = '';

    // Configurare paginatie
    $results_per_page = 3;
    $current_page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
    $offset = ($current_page - 1) * $results_per_page;

    // Obtinem litera selectată din URL
    $selected_letter = $_GET['letter'] ?? '';

    $where_clause = '';
    $params = [];
    $types = '';

    if (!empty($selected_letter) && preg_match('/^[A-Za-z]$/', $selected_letter)) {
        $where_clause = "WHERE books.title LIKE ?";
        $params[] = $selected_letter . '%';
        $types .= 's';
    }

    // Obtinem numarul total de carti filtrate
    $total_books_query = "SELECT COUNT(*) AS total FROM books $where_clause";
    $total_books = execute_query_and_fetch($total_books_query, $types, $params)[0]['total'];
    $total_pages = ceil($total_books / $results_per_page);

    // Obtinem cartile pentru pagina curenta
    $query = "
    SELECT books.id AS book_id, books.title, books.isbn, 
           GROUP_CONCAT(CONCAT(authors.first_name, ' ', authors.last_name) SEPARATOR ', ') AS authors
    FROM books
    LEFT JOIN author_book ON books.id = author_book.book_id
    LEFT JOIN authors ON authors.id = author_book.author_id
    $where_clause
    GROUP BY books.id
    ORDER BY books.title ASC
    LIMIT ? OFFSET ?
";

    $params[] = $results_per_page;
    $params[] = $offset;
    $types .= 'ii';

    $books = execute_query_and_fetch($query, $types, $params);

    include __DIR__ . "/../fragmente/book_list_admin.php";
}
