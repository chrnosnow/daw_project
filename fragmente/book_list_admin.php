<!-- Filtrare Alfabetică -->
<div class="alphabet-filter">
    <?php foreach (range('A', 'Z') as $letter): ?>
        <a href="?letter=<?= $letter ?>" class="<?= $selected_letter === $letter ? 'active' : '' ?>">
            <?= $letter ?>
        </a>
    <?php endforeach; ?>
    <a href="manage_book.php" class="<?= empty($selected_letter) ? 'active' : '' ?>">Toate</a>
</div>

<!-- Lista cărților -->
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Titlu</th>
            <th>ISBN</th>
            <th>Autori</th>
            <th>Actiuni</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($books)): ?>
            <?php foreach ($books as $book): ?>
                <tr>
                    <td><a href="../fragmente/book_details_admin.php?id=<?= $book['book_id'] ?>">
                            <?= htmlspecialchars($book['title']) ?></a></td>
                    <td><?= htmlspecialchars($book['isbn']) ?></td>
                    <td><?= htmlspecialchars($book['authors']) ?></td>
                    <td>
                        <a href="update_book.php?id=<?= $book['book_id'] ?>" class="btn btn-warning btn-sm edit">Modifica</a>
                        <a href="delete_book.php?id=<?= $book['book_id'] ?>" class="btn btn-danger btn-sm delete" onclick="return confirm('Esti sigur(a) ca vrei sa stergi aceasta carte?')">Sterge</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4">
                    <p class="text-center">Nu s-au gasit carti pentru filtrul selectat.</p>
                </td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<!-- Paginare -->
<nav>
    <ul class="pagination">
        <?php if ($current_page > 1): ?>
            <li class="page-item">
                <a class="page-link" href="?letter=<?= $selected_letter ?>&page=<?= $current_page - 1 ?>">Inapoi</a>
            </li>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <li class="page-item <?= $i === $current_page ? 'active' : '' ?>">
                <a class="page-link" href="?letter=<?= $selected_letter ?>&page=<?= $i ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>

        <?php if ($current_page < $total_pages): ?>
            <li class="page-item">
                <a class="page-link" href="?letter=<?= $selected_letter ?>&page=<?= $current_page + 1 ?>">Inainte</a>
            </li>
        <?php endif; ?>
    </ul>
</nav>
</div>
</body>

</html>