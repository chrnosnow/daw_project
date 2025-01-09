<?php
define('ALLOWED_ACCESS', true);
require __DIR__ . '/../pagini/common.php';

$errors = [];

if (is_admin()) {
    redirect_to('../pagini/profile_admin.php');
} elseif (is_user_logged_in()) {
    redirect_to('../pagini/profile.php');
}

if (is_post_req() && isset($_POST['signin'])) {
    $username = $_POST['uname'];
    $passw = $_POST['pass'];
    $username = sanitize_text($username);
    if (empty($username) || empty($passw)) {
        $errors['all_required'] = DEFAULT_VALIDATION_ERRORS['all_required'];
    }
    //reCAPTCHA checkbox validation
    $recaptcha = $_POST['g-recaptcha-response'];
    $verify_response = verify_captcha($recaptcha);
    if ($verify_response->success) {
        if (!login_user($username, $passw)) {
            $errors['wrong_login'] = DEFAULT_VALIDATION_ERRORS['invalid_login'];
        }
        // set time-limited session
        $_SESSION['last_activity'] = time(); // start session
        $_POST = [];
    } else {
        $errors['captcha_verify'] = 'Te rugam sa faci verificarea CAPTCHA.';
    }

    if (!empty($errors)) {
        $_SESSION['errors_login'] = $errors;
        redirect_to('../pagini/auth.php?form=login');
    }

    if (is_admin() === true) {
        redirect_to('../pagini/profile_admin.php');
    } else {
        redirect_to('../pagini/profile.php');
    }
} else {
    redirect_to("../pagini/index.php");
}
