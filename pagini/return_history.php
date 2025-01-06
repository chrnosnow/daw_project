<?php
define('ALLOWED_ACCESS', true);
require __DIR__ . '/../lib/common.php';

require_role(true);

// verifica daca timpul sesiunii a expirat
check_session_expiry();
// actualizeaza ultima activitate
$_SESSION['last_activity'] = time();
?>

<!DOCTYPE html>
<html lang="ro">

<head>
    <?php
    view('head', ['title' => 'Istoric carti returnate']);
    ?>
    <link rel="stylesheet" href="../resurse/css/books_admin.css" type="text/css">

    <style>
        .available-books {
            max-width: 100vw;
            height: auto;
        }

        .search-bar-user {
            width: 60%;
            padding-right: 0;
            margin-right: 0;

        }

        .search-bar-user form {
            display: flex;
            flex-grow: 1;
            align-items: flex-end;
            justify-content: flex-end;
        }

        .search-bar-user .form-group {
            display: inline-flex;
            height: 100%;

        }

        .search-box.search-box-user {
            padding: 0.375rem 0.75rem;
            border-bottom: solid 1px rgb(209, 208, 208);
        }

        .search-bar .search-btn-user {
            margin: 0;
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
            <h2>Istoricul cartilor returnate</h2>
        </div>
        <!-- bara cautare detalii imprumuturi-->
        <div class="search-bar search-bar-user container">
            <form action="" method="get" class="mb-3">
                <div class="form-group">
                    <input type="text" class="form-control search-box search-box-user" name="search" placeholder="Cauta detalii retur...">
                </div>
                <button type="submit" class="btn btn-primary search-btn-user">Cauta</i>
                </button>
            </form>
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
        <?php include __DIR__ . "/../admin/return_books_history.php"; ?>
    </div>
</div>
</main>
</body>

</html>