<?php
require_once __DIR__ . '/../config/database.php';

function insert_analytics($ip_address, $user_agent, $page_url, $book_id, $session_id)
{
    $query_insert = "INSERT INTO analytics (ip_address, user_agent, page_url, book_id, session_id) 
                     VALUES (?, ?, ?, ?, ?)";
    return execute_query($query_insert, 'sssis', [$ip_address, $user_agent, $page_url, $book_id, $session_id]);
}
function update_session_id($current_session_id, $previous_session_id)
{
    $query_update = "UPDATE analytics SET session_id = ? WHERE session_id = ?";
    return execute_query($query_update, 'ss', [$current_session_id, $previous_session_id]);
}

function get_total_visits()
{
    return execute_query_and_fetch("SELECT COUNT(*) AS total_visits FROM analytics");
}

function get_total_unique_visitors()
{
    return execute_query_and_fetch("SELECT COUNT(DISTINCT ip_address) AS unique_visitors FROM analytics");
}

function get_unique_ip_list()
{
    return execute_query_and_fetch("SELECT DISTINCT ip_address FROM analytics");
}
function get_visits_per_page($limit = 0, $offset = 0)
{
    if (empty($limit)) {
        $query = "
            SELECT 
                CASE 
                    WHEN book_id IS NOT NULL THEN CONCAT(page_url, '?id=', book_id)
                ELSE page_url
                END AS full_url,
                COUNT(*) AS visits
            FROM analytics
            GROUP BY full_url
            ORDER BY visits DESC
            LIMIT 20
        ";
        return execute_query_and_fetch($query);
    } else {
        $query = "
            SELECT 
                CASE 
                    WHEN book_id IS NOT NULL THEN CONCAT(page_url, '?id=', book_id)
                ELSE page_url
                END AS full_url,
                COUNT(*) AS visits
            FROM analytics
            GROUP BY full_url
            ORDER BY visits DESC
            LIMIT ? OFFSET ?
        ";
        return execute_query_and_fetch($query, 'ii', [$limit, $offset]);
    }
}
