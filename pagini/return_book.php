<?php
require_once __DIR__ . '/../lib/common.php';
?>

<!DOCTYPE html>
<html lang="ro">

<head>
    <?php
    view('head', ['title' => 'Returneaza o carte']);
    ?>
    <link rel="stylesheet" href="../resurse/css/books_admin.css" type="text/css">

    <style>
        .available-books {
            max-width: 100vw;
            height: auto;
        }

        input.form-control:read-only {
            color: grey;
        }

        .btn[name='refreshUser'] {
            margin-bottom: 1.5rem;
            background-color: var(--culoare-verde-deschis);
        }

        .btn[name='refreshUser']:hover {
            background-color: var(--culoare-hover);
        }

        .btn[name='returnCancel'] {
            background-color: var(--culoare-portocaliu);
        }

        .btn[name='returnCancel']:hover {
            background-color: var(--culoare-hover);
        }

        .cancel-borrow {
            color: brown;
            margin-top: 2rem;
            margin-bottom: 0.5rem;
        }

        .cancel-borrow p {
            margin-bottom: 0.5rem;
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
            <h2>Returneaza o carte</h2>
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
        <?php include __DIR__ . "/../fragmente/return_book_form.php"; ?>
    </div>
</div>
</main>
</body>

</html>