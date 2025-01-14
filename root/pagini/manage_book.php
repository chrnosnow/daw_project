<?php
define('ALLOWED_ACCESS', true);


require __DIR__ . '/../lib/common.php';

require_role(['admin']);

// verifica daca timpul sesiunii a expirat
check_session_expiry();
// actualizeaza ultima activitate
$_SESSION['last_activity'] = time();
?>

<!DOCTYPE html>
<html lang="ro">

<head>
    <?php
    view('head', ['title' => 'Gestioneaza o carte']);
    ?>
    <link rel="stylesheet" href="../resurse/css/books_admin.css" type="text/css">

    <style>
        .errors,
        .success {
            width: 50%;
        }
    </style>
</head>

<?php
require_once __DIR__ . '/../fragmente/header_user.php';
?>

<div class="wrapper">
    <?php
    require_once __DIR__ . "/../fragmente/sidebar_user.php";
    ?>
    <div class="wrapper-user-account">
        <div class="title">
            <h2>Gestioneaza o carte</h2>
        </div>
        <?php
        if (isset($_SESSION['errors'])) {
            display_alert('errors');
        }
        if (isset($_SESSION['success'])) {
            display_alert('success');
        }
        ?>
        <?php include __DIR__ . "/../book/search_admin.php"; ?>
    </div>
</div>
</main>
</body>

</html>