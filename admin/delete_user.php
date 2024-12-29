<?php
require_once __DIR__ . '/../lib/common.php';


$success = [];
$errors = [];

$user_id = $_GET['id'] ?? '';
$user = null;

if (!empty($user_id)) {
    $res = get_user_by_id($user_id);
    if (!empty($res)) {
        $user = $res[0];
    } else {
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
