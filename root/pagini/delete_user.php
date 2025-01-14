<?php
define('ALLOWED_ACCESS', true);


require_once __DIR__ . '/../lib/common.php';

require_role(['admin']);

// verifica daca timpul sesiunii a expirat
check_session_expiry();
// actualizeaza ultima activitate
$_SESSION['last_activity'] = time();

$success = [];
$errors = [];

if (is_get_req() && isset($_GET['id'])) {
    $user_id = $_GET['id'];
    $user = null;

    if (!empty($user_id)) {
        if (empty(get_user_by_id($user_id))) {
            $errors['user_not_found'] = "Utilizatorul nu a fost gasit.";
        }
    } else {
        $errors['user_id'] = "ID-ul utilizatorului nu este valid.";
    }

    if (!delete_user_by_id($user_id, 1)) {
        $errors['delete_user'] = 'A aparut o eroare la stergerea utilizatorului.';
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
    }

    $success['delete_user'] = 'Utilizatorul a fost sters cu succes.';
    $_SESSION['success'] = $success;

    redirect_to('../pagini/manage_users.php');
} else {
    redirect_to('../pagini/access_denied.php');
}
