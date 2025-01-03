<?php
require_once __DIR__ . '/../lib/common.php';
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
    require_once __DIR__ . '/../fragmente/header_user.php';
    ?>

    <div class="wrapper">
        <?php
        require_once __DIR__ . "/../fragmente/sidebar_user.php";
        ?>
        <div class="wrapper-user-account">
            <div class="title">
                <h2>Detalii carte</h2>
            </div>

            <?php
            if (isset($_SESSION['errors'])) {
                display_alert('errors');
            } else {
            ?>
                <div class="container mt-4">

                    <table class="table table-bordered">
                        <tr>
                            <th>Titlu</th>
                            <td><?= htmlspecialchars($book['title']) ?></td>
                        </tr>
                        <tr>
                            <th>Autori</th>
                            <td><?= htmlspecialchars($book['authors']) ?></td>
                        </tr>
                        <tr>
                            <th>Editura</th>
                            <td><?= htmlspecialchars($book['publisher'] ?? '-') ?></td>
                        </tr>
                        <tr>
                            <th>ISBN</th>
                            <td><?= htmlspecialchars($book['isbn']) ?></td>
                        </tr>
                        <tr>
                            <th>Editie</th>
                            <td><?= htmlspecialchars($book['edition'] ?? '-') ?></td>
                        </tr>
                        <tr>
                            <th>An aparitie</th>
                            <td><?= htmlspecialchars($book['publication_year'] ?? '-') ?></td>
                        </tr>
                        <tr>
                            <th>Limba</th>
                            <td><?= htmlspecialchars($book['language'] ?? '-') ?></td>
                        </tr>
                        <tr>
                            <th>Numar exemplare disponibile</th>
                            <td><?= htmlspecialchars($book['no_of_copies'] ?? '-') ?></td>
                        </tr>
                    </table>
                </div>
            <?php } ?>
            </body>

</html>