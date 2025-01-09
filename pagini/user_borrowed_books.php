<?php
define('ALLOWED_ACCESS', true);
require __DIR__ . '/../lib/common.php';

require_role(['user']);

// verifica daca timpul sesiunii a expirat
check_session_expiry();
// actualizeaza ultima activitate
$_SESSION['last_activity'] = time();
?>

<!DOCTYPE html>
<html lang="ro">

<head>
    <?php
    view('head', ['title' => 'Carti imprumutate']);
    ?>
    <link rel="stylesheet" href="../resurse/css/books_admin.css" type="text/css">
    <style>
        .btn.savePdf {
            background: var(--culoare-prim-albastru-inchis);
            color: white;
        }

        .btn:hover {
            background: var(--culoare-hover);
        }

        .a:visited {
            color: white;
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
            <h2>Carti imprumutate</h2>
        </div>

        <?php
        if (isset($_SESSION['errors'])) {
            display_alert('errors');
        }
        if (isset($_SESSION['alerts'])) {
            display_alert('alerts');
        }
        if (isset($_SESSION['success'])) {
            display_alert('success');
        }
        ?>
        <?php include __DIR__ . "/../book/user_books.php"; ?>

    </div>
</div>
</main>
</body>

</html>