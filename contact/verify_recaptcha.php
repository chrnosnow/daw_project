<?php
require_once __DIR__ . '/../lib/common.php';

$success = [];
$errors = [];


if (is_post_req() && isset($_POST['submit'])) {
    $username = sanitize_text($_POST['uname']);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $subject = sanitize_text($_POST['subject']);
    $message = sanitize_text($_POST['content']);

    if (empty($username) || empty($email)) {
        $errors['all_required'] = DEFAULT_VALIDATION_ERRORS['all_required'];
    }

    if (!validate_email($email)) {
        $errors['valid_email'] = sprintf(DEFAULT_VALIDATION_ERRORS['email'], $email);
    }

    $user = find_user_by_uname($username);
    if (!empty($user)) {
        if ($user[0]['email'] !== $email) {
            $errors['invalid_user'] = "Numele utilizatorului si/sau adresa de email sunt invalide.";
        }
    } else {
        $errors['find_user'] = "Utilizatorul nu a putut fi gasit.";
    }

    //reCAPTCHA checkbox validation
    $recaptcha = $_POST['g-recaptcha-response'];
    $verify_response = verify_captcha($recaptcha);
    if ($verify_response->success) {
        $message = "Nume utilizator: " . $username . "<br>Email: " . $email . "<br>Mesaj: " . $message;
        send_mail('morosanu.irina@gmail.com', '', $subject, $message);
        $success['mail_sent'] = "Mesajul a fost transmis cu succes.";
        $_SESSION['success'] = $success;
        $_POST = [];
    } else {
        $errors['captcha_verify'] = 'Te rugam sa faci verificarea CAPTCHA.';
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        redirect_to('../pagini/contact_us.php');
    }

    redirect_to('../pagini/contact_us.php');
} else {
    redirect_to("../pagini/index.php");
}
