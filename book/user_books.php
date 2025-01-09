<?php

require_once __DIR__ . '/../pagini/common.php';


$user = $_SESSION['user'];

$errors = get_user_summary($user['id']);
if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
}

include __DIR__ . '/../fragmente/book_list_user.php';
