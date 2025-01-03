<!-- Filtrare alfabetica -->
<div class="alphabet-filter">
    <?php foreach (range('A', 'Z') as $letter): ?>
        <a href="?letter=<?= $letter ?>" class="<?= $selected_letter === $letter ? 'active' : '' ?>">
            <?= $letter ?>
        </a>
    <?php endforeach; ?>
    <a href="manage_users.php" class="<?= empty($selected_letter) ? 'active' : '' ?>">Toti</a>
</div>

<!-- Lista utilizatorilor -->
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nume utilizator</th>
            <th>Email</th>
            <th>Numar permis</th>
            <th>Data crearii</th>
            <th>Data modificarii</th>
            <th>Actiune</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($users)): ?>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['username']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><?= htmlspecialchars($user['card_no']) ?></td>
                    <td><?= htmlspecialchars($user['created_at']) ?></td>
                    <td><?= htmlspecialchars($user['updated_at']) ?></td>
                    <td>
                        <a href="../admin/delete_user.php?id=<?= $user['user_id'] ?>" class="btn btn-danger btn-sm delete" onclick="return confirm('Esti sigur(a) ca vrei sa stergi acest utilizator?')">Sterge</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6">
                    <p class="text-center">Nu s-au gasit utilizatori pentru filtrul selectat.</p>
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