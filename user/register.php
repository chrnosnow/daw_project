<?php

require __DIR__ . '/../lib/common.php';


$errors = [];

$username = $_POST['uname'];
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$passw = $_POST['pass'];
$passw2 = $_POST['pass2'];

if (is_post_req()) {

    $username = sanitize_text($username);

    if (empty($username) && empty($email) && empty($passw) && empty($pass2)) {
        $errors['all_required'] = 'Toate campurile sunt obligatorii.';
    } elseif (empty($username)) {
        $errors['username_required'] = sprintf(DEFAULT_VALIDATION_ERRORS['required'], 'Campul NUME UTILIZATOR');
    } elseif (empty($email)) {
        $errors['email_required'] = sprintf(DEFAULT_VALIDATION_ERRORS['required'], 'Campul EMAIL');
    } elseif (empty($passw)) {
        $errors['passw_required'] = sprintf(DEFAULT_VALIDATION_ERRORS['required'], 'Campul PAROLA');
    } elseif (empty($passw2)) {
        $errors['passw2_required'] = sprintf(DEFAULT_VALIDATION_ERRORS['required'], 'Campul CONFIRMA PAROLA');
    }

    $min_len = 3;
    $max_len = 15;
    if (strlen($username) < $min_len || strlen($username) > $max_len) {
        $errors['username_len'] = sprintf(DEFAULT_VALIDATION_ERRORS['between'], 'Campul NUME UTILIZATOR', $min_len, $max_len);
    }

    if (!ctype_alnum($username)) {
        $errors['username_alphanum'] = sprintf(DEFAULT_VALIDATION_ERRORS['alphanumeric'], 'Campul NUME UTILIZATOR');
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = sprintf(DEFAULT_VALIDATION_ERRORS['email'], $email);
    }

    if (!validate_password($passw)) {
        $errors['passw'] = sprintf(DEFAULT_VALIDATION_ERRORS['secure'], 'Campul PAROLA');
    }

    if ($passw2 !== $passw) {
        $errors['passw2'] = sprintf(DEFAULT_VALIDATION_ERRORS['same'], 'Campurile PAROLA', 'CONFIRMA PAROLA');
    }

    if (is_unique($email, 'accounts', 'email')) {
        $errors['uniq_email'] = sprintf(DEFAULT_VALIDATION_ERRORS['unique'], 'Utilizatorul');
    }

    if (is_unique($email, 'accounts', 'username')) {
        $errors['uniq_username'] = sprintf(DEFAULT_VALIDATION_ERRORS['unique'], 'Utilizatorul');
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header('Location: ../pagini/auth.php');
        exit;
    }

    if (register_user("$email", "$username", "$passw")) {
        $_SESSION['registration_success'] = 'Inregistrarea s-a realizat cu succes.';
        header('Location: ../pagini/auth.php');
        exit;
    }
}
