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
    $where_clause_letter = "fees_list.email LIKE ?";
    $params[] = $selected_letter . '%';
    $types .= 's';
}

$search_term = $_GET['search'] ?? '';
$where_clause_search = '';
if (!empty($search_term)) {
    $search_term_sql = "%$search_term%";
    $where_clause_search = "UPPER(fees_list.title) LIKE UPPER(?)
                        OR UPPER(fees_list.isbn) LIKE UPPER(?)
                        OR UPPER(fees_list.email) LIKE UPPER(?)
                        OR UPPER(fees_list.card_no) LIKE UPPER(?)
                        OR UPPER(fees_list.status) = UPPER(?)
                        OR UPPER(fees_list.updated_at) LIKE UPPER(?)";
    for ($i = 0; $i < 6; $i++) {
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

// actualizam penalizarile de intarziere


// Obtinem numarul total de inregistrari filtrate
$fees_list_subquery = "
    SELECT users_fees.id, books.id AS book_id, books.title, books.isbn, users.email, users.card_no,
        users_fees.late_fee, users_fees.payment_status, users_fees.updated_at
    FROM users_fees
    JOIN books ON books.id = users_fees.book_id
    JOIN users ON users_fees.user_id = users.id
    ORDER BY users_fees.payment_status DESC, users.email ASC, users_fees.updated_at DESC
";
$total_books_query = "
    SELECT COUNT(*) AS total 
    FROM ($fees_list_subquery) AS fees_list
    $where_clause
";
$total_books = execute_query_and_fetch($total_books_query, $types, $params)[0]['total'];
$total_pages = ceil($total_books / $results_per_page);

//Obtinem pagina curenta a listei de carti filtrare
$query = "
    SELECT *  
    FROM ($fees_list_subquery) AS fees_list
    $where_clause
    LIMIT ? OFFSET ?
";
$params[] = $results_per_page;
$params[] = $offset;
$types .= 'ii';

$result = execute_query_and_fetch($query, $types, $params);

include __DIR__ . "/../fragmente/late_fee_history_form.php";
