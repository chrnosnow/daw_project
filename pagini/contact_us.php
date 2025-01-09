<?php
define('ALLOWED_ACCESS', true);
require __DIR__ . '/../lib/common.php';
?>

<!DOCTYPE html>
<html lang="ro">

<head>
    <?php
    view('head', ['title' => 'Formular de contact']);
    ?>
    <meta
        name="keywords"
        content="biblioteca, atena, mica bufnita, contact" />
    <meta
        name="description"
        content='Formular de contact a Bibliotecii "Mica bufnita a Atenei" din Iasi. Ne bucuram ca vrei sa iei legatura cu noi.' />

    <style>
        .container.wrapper-book {
            max-width: 60vw;
            margin: auto;
        }

        .title {
            margin: auto;
            padding-top: 1rem;
        }

        .btn {
            width: 25%;
        }

        footer {
            background-color: var(--culoare-crem-deschis);
        }
    </style>
</head>

<?php
require_once __DIR__ . '/../fragmente/header.php';
?>

<div id="grid-pagina">
    <div class="wrapper-user-account">
        <div class="title">
            <h2>Formular de contact</h2>
        </div>
        <div class="form-wrapper">
            <?php
            if (isset($_SESSION['errors'])) {
                display_alert('errors');
            }
            if (isset($_SESSION['success'])) {
                display_alert('success');
            }
            ?>
            <?php
            include __DIR__ . "/../fragmente/contact_form.php";
            ?>
        </div>
    </div>

</div>

</main>
</body>
<?php
require_once __DIR__ . '/../fragmente/footer.php';
?>


</html>