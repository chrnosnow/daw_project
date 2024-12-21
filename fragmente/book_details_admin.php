<?php
require_once __DIR__ . '/../lib/common.php';
require_once __DIR__ . '/../book/book_info.php';
?>
<!DOCTYPE html>
<html lang="ro">

<head>
    <?php
    view('head', ['title' => $book_title ?? 'Detalii carte']);
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
                    <form action="" method="post">
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
                            <label for="author_ids">Autori (separati prin virgula)*</label>
                            <input type="text" class="form-control" id="authors" name="authors" value="<?= htmlspecialchars($book['authors']) ?>">
                        </div>
                        <button type="submit" class="btn btn-primary saveBook">Salveaza</button>
                        <a href="book_details.php?id=<?= $book_id ?>" class="btn btn-secondary">Anuleaza</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </main>
    </body>

</html>