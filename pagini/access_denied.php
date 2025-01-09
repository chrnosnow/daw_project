<?php
define('ALLOWED_ACCESS', true);
require __DIR__ . '/common.php';
?>

<!DOCTYPE html>
<html lang="ro">

<head>
    <?php
    view('head', ['title' => 'Acces refuzat']);
    ?>
    <link rel="stylesheet" href="../resurse/css/books_admin.css" type="text/css">
    <style>
        /* .wrapper {
            height: 40vh;
        } */

        a.btn {
            color: white;
            width: 50vw;
        }

        footer {
            background-color: var(--culoare-crem-deschis);
        }
    </style>

</head>

<?php
require_once __DIR__ . '/../fragmente/header.php';
?>

<div class="wrapper">

    <div class="wrapper-user-account">
        <div class="title">
            <h2>Acces refuzat</h2>
        </div>
        <div>
            <p>Nu aveti permisiunea sa accesati aceasta pagina.</p>
        </div>
        <a href="./auth.php" class="btn btn-warning btn-sm">Autentificare</a>
    </div>
</div>
</main>
</body>
<?php
require_once __DIR__ . '/../fragmente/footer.php';
?>

</html>