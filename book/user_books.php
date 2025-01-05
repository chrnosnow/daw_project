<?php

require_once __DIR__ . '/../lib/common.php';

if (is_user_logged_in()) {
    $user = $_SESSION['user'];

    // $books = get_borrowed_books_by_user($user['id']);
    $errors = get_user_summary($user['id']);
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
    }

    include __DIR__ . '/../fragmente/book_list_user.php';
} else {
    redirect_to('../pagini/access_denied.php');
}
