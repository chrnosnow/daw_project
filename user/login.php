<?php

require __DIR__ . '/../lib/common.php';

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
        redirect_to('../pagini/auth.php?form=login');
    }

    //if login is successful
    // set time-limited session
    $_SESSION['last_activity'] = time(); // start session

    if (is_admin() === true) {
        redirect_to('../pagini/profile_admin.php');
    } else {
        redirect_to('../pagini/profile.php');
    }
}

if (is_admin()) {
    redirect_to('../pagini/profile_admin.php');
} elseif (is_user_logged_in()) {
    redirect_to('../pagini/profile.php');
}
