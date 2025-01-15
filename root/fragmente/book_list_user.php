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
                    <td><a href="../pagini/book_details.php?id=<?= $book['book_id'] ?>" target="_blank">
                            <?= htmlspecialchars($book['title']) ?></a></td>
                    <td><?= htmlspecialchars($book['isbn']) ?></td>
                    <td><?= htmlspecialchars($book['authors']) ?></td>
                    <td><?= htmlspecialchars($book['due_date']) ?></td>
                    <td><?= htmlspecialchars($book['days_late']) ?></td>
                    <td><?= number_format($book['late_fee'], 2) ?></td>
                </tr>
            <?php endforeach; ?>
            <tr style="font-weight: 600;">
                <td colspan="5">TOTAL</td>
                <td><?= number_format($total_late_fee, 2) ?></td>
            </tr>
        <?php else: ?>
            <tr>
                <td colspan="6">
                    <p class="text-center">Nu s-au gasit carti imprumutate.</p>
                </td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
<div>
    <a href="../pagini/save_user_fees.php?saveAs=pdf" target="_blank" class="btn btn-sm savePdf">Salveaza ca pdf</a>
</div>
</div>
</body>

</html>