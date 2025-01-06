<?php

require __DIR__ . '/../lib/common.php';

$success = [];
$errors = [];
$alerts = [];

if (is_post_req() && isset($_POST['signup'])) {

    $username = sanitize_text($_POST['uname']);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $passw = $_POST['pass'];
    $passw2 = $_POST['pass2'];
    $gdpr = isset($_POST['gdpr']) ? true : false;

    if (empty($username) || empty($email) || empty($passw) || empty($passw2)) {
        $errors['all_required'] = DEFAULT_VALIDATION_ERRORS['all_required'];
    }

    $min_len = 3;
    $max_len = 15;
    if (strlen($username) < $min_len || strlen($username) > $max_len) {
        $errors['username_len'] = sprintf(DEFAULT_VALIDATION_ERRORS['between'], 'Campul NUME UTILIZATOR', $min_len, $max_len);
    }

    if (!ctype_alnum($username)) {
        $errors['username_alphanum'] = sprintf(DEFAULT_VALIDATION_ERRORS['alphanumeric'], 'Campul NUME UTILIZATOR');
    }

    if (!validate_email($email)) {
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

    if (!is_unique($username, 'users', 'username') || !is_unique($email, 'users', 'email')) {
        $errors['uniq_user'] = sprintf(DEFAULT_VALIDATION_ERRORS['unique'], 'Utilizatorul');
    }

    //reCAPTCHA checkbox validation
    $recaptcha = $_POST['g-recaptcha-response'];
    $verify_response = verify_captcha($recaptcha);
    if (!$verify_response->success) {
        $errors['captcha_verify'] = 'Te rugam sa faci verificarea CAPTCHA.';
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        redirect_to('../pagini/auth.php?form=register');
    }

    $activation_code = generate_activation_code();
    if (register_user("$email", "$username", "$passw", $gdpr, "$activation_code")) {
        $alerts['msg-activare-cont'] = "Va rugam sa va verificati emailul si sa urmati pasii necesari pentru activarea contului de utilizator.";
        $_SESSION['alerts'] = $alerts;

        send_activation_email($email, $username, $activation_code);
        $_POST = [];

        redirect_to('../pagini/auth.php?form=register');
    }
}
