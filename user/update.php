<?php
require_once __DIR__ . '/../lib/common.php';

$success = [];
$errors = [];
$alerts = [];

$id = $_SESSION['user']['id'];
$current_username = $_SESSION['user']['username'];
$current_email = $_SESSION['user']['email'];

if (is_post_req() && isset($_POST['saveDetails'])) {

    $username = sanitize_text($_POST['uname']);

    if ($username === $current_username) {
        $success['saved'] = "Datele personale au fost salvate cu succes.";
    }

    if (empty($username)) {
        $errors['required'] = sprintf(DEFAULT_VALIDATION_ERRORS['required'], 'Numele de utilizator');
    }

    $min_len = 3;
    $max_len = 15;
    if ($username !== $current_username) {
        if (strlen($username) < $min_len || strlen($username) > $max_len) {
            $errors['username_len'] = sprintf(DEFAULT_VALIDATION_ERRORS['between'], 'Campul NUME UTILIZATOR', $min_len, $max_len);
        }

        if (!ctype_alnum($username)) {
            $errors['username_alphanum'] = sprintf(DEFAULT_VALIDATION_ERRORS['alphanumeric'], 'Campul NUME UTILIZATOR');
        }
        if (!is_unique($username, 'users', 'username')) {
            $errors['uniq_user'] = sprintf(DEFAULT_VALIDATION_ERRORS['unique'], 'Utilizatorul');
        }
    }

    if (!update_username($id, $username)) {
        $errors['saved'] = "Datele personale nu au putut fi salvate.";
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        redirect_to('../pagini/personal_info.php');
    }

    $success['saved'] = "Datele personale au fost salvate cu succes.";
    $_SESSION['success'] = $success;
    $new_username = execute_query_and_fetch("SELECT username FROM users WHERE id = ?", "i", [$id]);
    $_SESSION['user']['username'] = $new_username[0]['username'];

    redirect_to('../pagini/personal_info.php');
}

if (is_post_req() && isset($_POST['savePassw'])) {

    $user_passw = execute_query_and_fetch("SELECT password FROM users WHERE id = ?", "i", [$id]);
    if (empty($user_passw)) {
        $errors['user_not_found'] = "Utilizatorul nu a fost gasit.";
    }
    $hashed_passw = $user_passw[0]['password'];
    $current_passw = $_POST['current_pass'] ?? '';
    $passw = $_POST['pass'] ?? '';
    $passw2 = $_POST['pass2'] ?? '';

    if (empty($current_passw) || empty($passw) || empty($passw2)) {
        $errors['all_required'] = DEFAULT_VALIDATION_ERRORS['all_required'];
    }

    if (!password_verify($current_passw, $hashed_passw)) {
        $errors['incorrect_passw'] = "Parola curenta este incorecta.";
    }

    if (!validate_password($passw)) {
        $errors['passw'] = sprintf(DEFAULT_VALIDATION_ERRORS['secure'], 'Campul PAROLA');
    }

    if ($passw2 !== $passw) {
        $errors['passw2'] = sprintf(DEFAULT_VALIDATION_ERRORS['same'], 'Campurile PAROLA', 'CONFIRMA PAROLA');
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        redirect_to('../pagini/change_password.php');
    }

    $activation_code = password_hash(generate_activation_code(), PASSWORD_DEFAULT);
    $time = new DateTime('now', new DateTimeZone('Europe/Bucharest'));
    $act_expiry = $time->add(new DateInterval('PT20M'));
    $act_expiry = $act_expiry->format('Y-m-d H:i:s');
    $insert_code_query = "INSERT INTO password_resets (user_id, email, new_password, activation_code, activation_expiry) VALUES(?,?,?,?,?)";
    $new_passw = password_hash($passw, PASSWORD_BCRYPT);

    if (execute_query($insert_code_query, "issss", [$id, $current_email, $new_passw, $activation_code, $act_expiry])) {
        $alerts['msg-activare-passw'] = "Un email de confirmare a fost trimis la adresa ta.";
        $_SESSION['alerts'] = $alerts;

        send_email_change_passw($_SESSION['user']['email'], $_SESSION['user']['username'], $activation_code);

        redirect_to('../pagini/change_password.php');
    }
}

$_POST = [];
session_regenerate_id(true);
