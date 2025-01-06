<?php
require_once __DIR__ . '/../lib/common.php';
require_once __DIR__ . '/../book/book_info.php';
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