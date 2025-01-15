<?php
define('ALLOWED_ACCESS', true);


require_once __DIR__ . '/../lib/common.php';
require_once __DIR__ . '/../book/book_info.php';

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
    view('head', ['title' => $book['title'] ?? 'Detalii carte']);
    ?>
    <link rel="stylesheet" href="../resurse/css/books_admin.css" type="text/css">

    <?php
    require_once __DIR__ . '/../fragmente/header_user.php';
    ?>

    <div class="wrapper">
        <?php
        require_once __DIR__ . "/../fragmente/sidebar_user.php";
        ?>
        <div class="wrapper-user-account ">
            <div class="title">
                <h2>Modifica o carte</h2>
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
                <div class="container mt-4 wrapper-book">
                    <form action="../book/update_book.php" method="post">
                        <input type="hidden" name="token_processing" value="<?= generate_form_token() ?>">
                        <input type="hidden" name="book_id" value="<?= $book_id ?>">
                        <div class="form-group">
                            <label for="title">Titlu*</label>
                            <input type="text" class="form-control" id="title" name="title" value="<?= htmlspecialchars($book['title']) ?>">
                        </div>
                        <div class="form-group">
                            <label for="edition">Editie</label>
                            <input type="text" class="form-control" id="edition" name="edition" value="<?= htmlspecialchars($book['edition']) ?? '-' ?>">
                        </div>
                        <div class="form-group">
                            <label for="isbn">ISBN*</label>
                            <input type="text" class="form-control" id="isbn" name="isbn" value="<?= htmlspecialchars($book['isbn']) ?>">
                        </div>
                        <div class="form-group">
                            <label for="publisher">Editura</label>
                            <input type="text" class="form-control" id="publisher" name="publisher" value="<?= htmlspecialchars($book['publisher']) ?? '-' ?>">
                        </div>
                        <div class="form-group">
                            <label for="public_yr">An aparitie</label>
                            <input type="text" class="form-control" id="public_yr" name="public_yr" value="<?= htmlspecialchars($book['publication_year']) ?? '-' ?>">
                        </div>
                        <div class="form-group">
                            <label for="lang">Limba</label>
                            <input type="text" class="form-control" id="lang" name="lang" value="<?= htmlspecialchars($book['language']) ?? '-' ?>">
                        </div>
                        <div class="form-group">
                            <label for="lang">Numar exemplare</label>
                            <input type="text" class="form-control" id="no_of_copies" name="no_of_copies" value="<?= number_format($book['no_of_copies']) ?? '-' ?>">
                        </div>
                        <div class="form-group">
                            <label for="author_ids">Autori (separati prin virgula)*</label>
                            <input type="text" class="form-control" id="authors" name="authors" value="<?= htmlspecialchars($book['authors']) ?>">
                        </div>
                        <button type="submit" class="btn btn-primary" name="saveBook">Salveaza</button>
                        <a href="./update_book.php?id=<?= $book_id ?>" class="btn btn-secondary">Anuleaza</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </main>
    </body>

</html>