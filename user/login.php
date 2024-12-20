<?php

require __DIR__ . '/../lib/common.php';

if (is_user_logged_in()) {
    redirect_to('../pagini/profile.php');
}

$errors = [];

if (is_post_req() && isset($_POST['signin'])) {
    $username = $_POST['uname'];
    $passw = $_POST['pass'];
    $username = sanitize_text($username);

    if (!login_user($username, $passw)) {
        $errors['wrong_login'] = DEFAULT_VALIDATION_ERRORS['invalid_login'];
    }

    if (!empty($errors)) {
        $_SESSION['errors_login'] = $errors;
        header('Location: ../pagini/auth.php?form=login');
        exit;
    }

    //if login is successful
    redirect_to('../pagini/profile.php');
}
