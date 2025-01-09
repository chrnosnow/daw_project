<?php
require_once __DIR__ . '/../pagini/common.php';
require_once __DIR__ . '/../book/book_info.php';
?>

<div class="book_details">
    <div class="book_img">
        <?php if (!empty($ol_id)): ?>
            <a href="<?= "https://openlibrary.org/olid/{$ol_id}" ?>"><img src=<?= "https://covers.openlibrary.org/b/isbn/{$book['isbn']}-M.jpg" ?> alt="book cover"></a>
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
                <th>Evaluare <a href="https://openlibrary.org/">Open Library</a></th>
                <td>
                    <?php if (!empty($ratings)) {
                        echo number_format($ratings['ratings_average'], 1) . " (" . $ratings['ratings_count'] . (($ratings['ratings_count'] === 1) ? " evaluare)" : " evaluari)");
                    } else {
                        echo "-";
                    } ?>
                </td>
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
</div>