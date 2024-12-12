<?php

require __DIR__ . '/../lib/common.php';

$success = [];
$errors = [];

if (is_post_req() && isset($_POST['signup'])) {
    var_dump($_POST);
    $username = sanitize_text($_POST['uname']);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $passw = $_POST['pass'];
    $passw2 = $_POST['pass2'];
    $gdpr = isset($_POST['gdpr']) ? true : false;

    if (empty($username) || empty($email) || empty($passw) || empty($passw2)) {
        $errors['all_required'] = 'Toate campurile sunt obligatorii.';
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
        $errors['valid_email'] = sprintf(DEFAULT_VALIDATION_ERRORS['email'], $email);
    }

    if (!validate_password($passw)) {
        $errors['passw'] = sprintf(DEFAULT_VALIDATION_ERRORS['secure'], 'Campul PAROLA');
    }

    if ($passw2 !== $passw) {
        $errors['passw2'] = sprintf(DEFAULT_VALIDATION_ERRORS['same'], 'Campurile PAROLA', 'CONFIRMA PAROLA');
    }

    if (!$gdpr) {
        $errors['gdpr'] = 'Trebuie sa fiti de acord cu politica de confidentialitate.';
    }

    if (!is_unique($username, 'accounts', 'username') || !is_unique($email, 'accounts', 'email')) {
        $errors['uniq_user'] = sprintf(DEFAULT_VALIDATION_ERRORS['unique'], 'Utilizatorul');
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        redirect_to('../pagini/auth.php?form=register');
    }

    if (register_user("$email", "$username", "$passw", $gdpr)) {
        $success['registration_success'] = 'Inregistrarea s-a realizat cu succes. Puteti accesa contul.';
        $_SESSION['registration'] = $success;
        redirect_to('../pagini/auth.php?form=login');
    }
}
