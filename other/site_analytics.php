<?php
require_once __DIR__ . '/../lib/common.php';

$success = [];
$errors = [];

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$ip_address = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
$page_url = $_SERVER['REQUEST_URI'] ?? 'unknown';
// mentinem intrari separate pentru accesarile fiecarei carti
$normalized_url = strtok($page_url, '?');
$book_id = null;
if (strpos($normalized_url, 'book_details.php') !== false) {
    parse_str(parse_url($page_url, PHP_URL_QUERY), $query_params);
    $book_id = $query_params['id'] ?? null;
}

$current_session_id = session_id();


// daca ID-ul sesiunii a fost regenerat, actualizeaza in baza de date
if (isset($_SESSION['previous_session_id'])) {
    $previous_session_id = $_SESSION['previous_session_id'];

    if (!update_session_id($current_session_id, $previous_session_id)) {
        $errors['session_id_not_updated'] = "ID-ul sesiunii nu a putut fi actualizat.";
    } else {
        unset($_SESSION['previous_session_id']);
    }
}

// Verificam daca accesarea curenta este deja logata
$query_check = "SELECT COUNT(*) AS count FROM analytics 
                WHERE ip_address = ? AND session_id = ? AND page_url = ? AND (book_id = ? OR book_id IS NULL)";
$count = execute_query_and_fetch($query_check, 'sssi', [$ip_address, $current_session_id, $normalized_url, $book_id])[0]['count'];
$is_duplicate = $count > 0;

if (!$is_duplicate) {
    if (!insert_analytics($ip_address, $user_agent, $normalized_url, $book_id, $current_session_id)) {
        $errors['insert_analytics'] = "Nu s-a putut adauga o inregistrare noua in baza de date";
    }
}
