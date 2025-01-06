<table class="table table-bordered">
    <thead>
        <tr>
            <th>Titlu</th>
            <th>ISBN</th>
            <th>Autori</th>
            <th>Data scadenta</th>
            <th>Intarziere (zile)</th>
            <th>Penalizare (lei)</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($books_fees)): ?>
            <?php foreach ($books_fees as $book): ?>
                <tr>
                    <td><a href="../pagini/book_details.php?id=<?= $book['book_id'] ?>">
                            <?= htmlspecialchars($book['title']) ?></a></td>
                    <td><?= htmlspecialchars($book['isbn']) ?></td>
                    <td><?= htmlspecialchars($book['authors']) ?></td>
                    <td><?= htmlspecialchars($book['due_date']) ?></td>
                    <td><?= htmlspecialchars($book['days_late']) ?></td>
                    <td><?= number_format($book['late_fee'], 2) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6">
                    <p class="text-center">Nu s-au gasit carti imprumutate.</p>
                </td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
</div>
</body>

</html>