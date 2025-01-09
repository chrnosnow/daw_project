<?php
define('ALLOWED_ACCESS', true);
require __DIR__ . '/common.php';



if (is_get_req()) {
    $email = filter_input(INPUT_GET, 'email', FILTER_SANITIZE_EMAIL);
    $activation_code = sanitize_text($_GET['activation_code']);

    $err = [];
    if (empty($email) || empty($activation_code)) {
        $errors['all_req_activation'] = 'Toate campurile sunt obligatorii in linkul de activare.';
    }

    if (!validate_email(trim($_GET['email']))) {
        $err['valid_email_activation'] = sprintf(DEFAULT_VALIDATION_ERRORS['email'], $email);
    }


    if (empty($err)) {
        $user = find_unactivated_password($activation_code, $email); // $user[0] {['user_id], ['new_password'],['expired']}
        var_dump($user);
        echo "<br>";
        echo "<br>";
        if ($user && activate_change_password($user[0]['user_id'], $user[0]['new_password'])) {
            if (!delete_passw($activation_code)) {
                $err['del_passw'] = 'Parola nu a fost stearsa';
                $_SESSION['errors_change_passw'] = $err;
                redirect_to('../pagini/change_password.php');
            };

            $success['change_passw_success'] = 'Parola a fost schimbata cu succes.';
            $_SESSION['success'] = $success;

            // masuri mai stricte
            // session_unset();
            // session_destroy();
            // redirect_to('../pagini/auth.php?form=login');

            // session_regenerate_id(true);
            redirect_to('../pagini/change_password.php');
        }
    }

    $err['activation_failed'] = DEFAULT_VALIDATION_ERRORS['invalid_activation'];
    $_SESSION['errors'] = $err;

    redirect_to('../pagini/change_password.php');
}
