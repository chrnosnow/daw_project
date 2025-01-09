<?php
define('ALLOWED_ACCESS', true);
require_once __DIR__ . '/../pagini/common.php';
require_once __DIR__ . '/../book/book_info.php';
?>


<!DOCTYPE html>
<html lang="ro">

<head>
    <?php
    view('head', ['title' => $book['title'] ?? 'Detalii carte']);
    ?>
    <link rel="stylesheet" href="../resurse/css/books_admin.css" type="text/css">

    <style>
        .errors {
            width: 50%;
        }
    </style>

    <?php
    require_once __DIR__ . '/../fragmente/header.php';
    ?>

    <div class="wrapper">

        <div class="wrapper-user-account">
            <div class="title">
                <h2>Detalii carte</h2>
            </div>
            <?php
            if (isset($_SESSION['errors'])) {
                display_alert('errors');
            } else {
                include __DIR__ . '/../fragmente/book_details_user.php';
            }
            ?>
        </div>
    </div>
    </main>
    </body>
    <?php
    require_once __DIR__ . '/../fragmente/footer.php';
    ?>

</html>