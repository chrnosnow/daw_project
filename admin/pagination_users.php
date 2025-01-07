<?php

require_once __DIR__ . '/../lib/common.php';


// folosim paginatie pentru afisarea rezultatelor
$users = [];
$search_term = '';

// Configurare paginatie
$results_per_page = 3;
$current_page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($current_page - 1) * $results_per_page;

// Obtinem litera selectată din URL
$selected_letter = $_GET['letter'] ?? '';

$where_clause = 'WHERE active = 1';
$params = [];
$types = '';

if (!empty($selected_letter) && preg_match('/^[A-Za-z]$/', $selected_letter)) {
    $where_clause .= " AND username LIKE ?";
    $params[] = $selected_letter . '%';
    $types .= 's';
}

$search_term = $_GET['search'] ?? '';
if (!empty($search_term)) {
    $search_term_sql = "%$search_term%";
    $where_clause .= " AND UPPER(username) LIKE UPPER(?)
                        OR UPPER(email) LIKE UPPER(?)
                        OR UPPER(card_no) LIKE UPPER(?)";
    $params = [$search_term_sql, $search_term_sql, $search_term_sql];
    $types .= 'sss';
}


// Obtinem numarul total de utilizatori filtrati
$total_users_query = "SELECT COUNT(*) AS total FROM users $where_clause";
$total_users = execute_query_and_fetch($total_users_query, $types, $params)[0]['total'];
$total_pages = ceil($total_users / $results_per_page);

// Obtinem utilizatorii pentru pagina curenta
$query = "
    SELECT id AS user_id, username, email, card_no, is_admin, created_at, updated_at
    FROM users
    $where_clause
    ORDER BY is_admin DESC, username ASC
    LIMIT ? OFFSET ?
";

$params[] = $results_per_page;
$params[] = $offset;
$types .= 'ii';

$users = execute_query_and_fetch($query, $types, $params);

include __DIR__ . "/../fragmente/users_list_admin.php";
