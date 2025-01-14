<?php
require_once __DIR__ . '/../lib/common.php';
require_once __DIR__ . '/../book/book_info.php';

?>

<div class="book_details">
    <div class="book_img">
        <?php if (!empty($ol_id)): ?>
            <a href="<?= "https://openlibrary.org/books/{$ol_id}" ?>" target="_blank"><img src=<?= "https://covers.openlibrary.org/b/isbn/{$book['isbn']}-M.jpg" ?> alt="book cover"></a>
        <?php else: ?>
            <img src="../resurse/imagini/mba_book_cover_default.jpg" alt="book cover" id="default_cover">
        <?php endif; ?>
    </div>
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
            <?php if (is_user_logged_in()): ?>
                <tr>
                    <th>Numar exemplare disponibile</th>
                    <td><?= htmlspecialchars($book['no_of_copies'] ?? '-') ?></td>
                </tr>
            <?php endif; ?>
            <tr>
                <?php if (!empty($id_goodreads)): ?>
                    <th>Evaluare <a href="https://www.goodreads.com/book/show/<?= $id_goodreads ?>" target="_blank">Goodreads</a></th>
                <?php else: ?>
                    <th>Evaluare <a href="https://www.goodreads.com/" target="_blank">Goodreads</a></th>
                <?php endif; ?>
                <?php if (!empty($ratings)): ?>
                    <td><?= $ratings['ratings_average'] . " (" . $ratings['review_count'] . (($ratings['review_count'] === 1) ? " recenzie)" : " recenzii)") ?></td>
                <?php else: ?>
                    <td> <?= "-" ?> </td>
                <?php endif; ?>
            </tr>
        </table>
    </div>
</div>