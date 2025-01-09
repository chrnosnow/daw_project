<div class="available-books">
    <!-- Filtrare alfabetica -->
    <div class="alphabet-filter">
        <?php foreach (range('A', 'Z') as $letter): ?>
            <a href="?letter=<?= $letter ?>" class="<?= $selected_letter === $letter ? 'active' : '' ?>">
                <?= $letter ?>
            </a>
        <?php endforeach; ?>
        <a href="return_history.php" class="<?= empty($selected_letter) ? 'active' : '' ?>">Toate</a>
    </div>

    <div class="form-group">
        <!-- Lista cartilor -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Titlu</th>
                    <th>ISBN</th>
                    <th>Autori</th>
                    <th>Email</th>
                    <th>Numar permis</th>
                    <th>Data imprumut</th>
                    <th>Data returnare</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($result)): ?>
                    <?php foreach ($result as $res): ?>
                        <tr>
                            <td><?= htmlspecialchars($res['title']) ?></td>
                            <td><?= htmlspecialchars($res['isbn']) ?></td>
                            <td><?= htmlspecialchars($res['authors']) ?></td>
                            <td><?= htmlspecialchars($res['email']) ?></td>
                            <td><?= htmlspecialchars($res['card_no']) ?></td>
                            <td><?= htmlspecialchars($res['borrowed_at']) ?></td>
                            <td><?= htmlspecialchars($res['returned_at']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">
                            <p class="text-center">Nu s-au gasit carti pentru filtrul selectat.</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

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