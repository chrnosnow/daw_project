<?php
require __DIR__ . '/../lib/common.php';
?>

<!DOCTYPE html>
<html lang="ro">

<head>
    <?php
    view('head', ['title' => 'Modifica sau sterge o carte']);
    ?>
    <link rel="stylesheet" href="../resurse/css/books_admin.css" type="text/css">

    <style>
        .errors,
        .success {
            width: 50%;
        }
    </style>

    <?php
    require_once __DIR__ . '/../fragmente/header_user.php';
    ?>

    <div class="wrapper">
        <?php
        require_once __DIR__ . "/../fragmente/sidebar_user.php";
        ?>
        <div class="wrapper-user-account">
            <div class="title">
                <h2>Modifica sau sterge o carte</h2>
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