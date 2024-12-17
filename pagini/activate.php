<?php

require __DIR__ . '/../lib/common.php';

if (is_get_req()) {
    $email = filter_input(INPUT_GET, 'email', FILTER_SANITIZE_EMAIL);

    $activation_code = sanitize_text($_GET['activation_code']);

    $err = [];
    if (!isset($email) || empty($email) || !isset($activation_code) || empty($activation_code)) {
        $errors['all_req_activation'] = 'Toate campurile sunt obligatorii in linkul de activare.';
    }

    if (!validate_email(trim($_GET['email']))) {
        $err['valid_email_activation'] = sprintf(DEFAULT_VALIDATION_ERRORS['email'], $email);
    }
    print_r($err);
    if (empty($err)) {
        $user = find_unactivated_user($activation_code, $email);

        if ($user && activate_user($user[0]['id'])) {
            $success['registration_success'] = 'Activarea contului s-a realizat cu succes. Puteti accesa contul.';
            $_SESSION['registration'] = $success;
            redirect_to('../pagini/auth.php?form=login');
        }
    }

    $err['activation_failed'] = DEFAULT_VALIDATION_ERRORS['invalid_activation'];
    $_SESSION['errors_activation'] = $err;
    redirect_to('../pagini/auth.php?form=register');
}
