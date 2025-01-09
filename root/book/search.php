<?php

require_once __DIR__ . '/../lib/common.php';

$errors = [];

// folosim paginatie pentru afisarea rezultatelor
$books = [];
$search_term = '';

// Configurare paginatie
$results_per_page = 3;
$current_page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($current_page - 1) * $results_per_page;

if (is_get_req() && !empty($_GET['search'])) {

    $search_term = sanitize_text($_GET['search']);

    if (!empty($search_term)) {
        if ($search_term === 'all') {
            $books = get_all_books();
        } else {
            $search_term_sql = "%$search_term%";

            // folosim group_concat pt a crea lista de autori unde exista carti cu mai multi autori
            $query = "
            SELECT books.id AS book_id, books.title, books.isbn, 
                   GROUP_CONCAT(CONCAT(authors.first_name, ' ', authors.last_name) SEPARATOR ', ') AS authors, books.no_of_copies
            FROM books
            LEFT JOIN author_book ON books.id = author_book.book_id
            LEFT JOIN authors ON authors.id = author_book.author_id
            WHERE UPPER(books.title) LIKE UPPER(?) 
               OR UPPER(books.isbn) LIKE UPPER(?)
               OR UPPER(authors.first_name) LIKE UPPER(?)
               OR UPPER(authors.last_name) LIKE UPPER(?)
            GROUP BY books.id
            ORDER BY books.title;
        ";
            $params = [$search_term_sql, $search_term_sql, $search_term_sql, $search_term_sql];
            $books = execute_query_and_fetch($query, "ssss", $params);
        }
    }

    if (empty($books)) {
        $_SESSION['errors_search'] = array("search_result" => "Nu s-au gasit rezultate pentru cautarea ta.");
    }
} else {
    $errors['search_term_req'] = "Introdu un cuvant de cautare";
}
// echo "gsldboglrn";
$_SESSION['errors'] = $errors;
//numarul total de carti rezultate
$total_books = count($books);
$total_pages = ceil($total_books / $results_per_page);


include __DIR__ . "/../fragmente/search_results.php";
