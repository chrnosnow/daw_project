<?php
$user = $_SESSION['borrowing_user'] ?? null;
?>
<div class="container mt-4 wrapper-book">
    <h3>Pasul 1 - Verificare utilizator</h3>
    <form action="../admin/lend_book.php" method="post">
        <?php if ($user) { ?>
            <div class="form-group">
                <label for="email">Email*</label>
                <input type="text" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" readonly>
            </div>
            <div class="form-group">
                <label for="card_no">Numar permis*</label>
                <input type="text" class="form-control" id="library_card" name="library_card" value="<?= htmlspecialchars($user['card_no']) ?>" readonly>
            </div>
        <?php } else { ?>
            <div class="form-group">
                <label for="email">Email*</label>
                <input type="text" class="form-control" id="email" name="email">
            </div>
            <div class="form-group">
                <label for="card_no">Numar permis*</label>
                <input type="text" class="form-control" id="library_card" name="library_card">
            </div>
        <?php } ?>
        <input type="submit" class="btn btn-primary" name="lendUser" value="Verifica utilizator"></input>
    </form>
</div>

<div class="available-books">
    <div>
        <h3>Pasul 2 - Selectare dintre cartile disponibile</h3>
        <h6>(selectia se pierde cu schimbarea paginii in lista de carti)</h6>
    </div>

    <!-- Filtrare alfabetica -->
    <div class="alphabet-filter">
        <?php foreach (range('A', 'Z') as $letter): ?>
            <a href="?letter=<?= $letter ?>" class="<?= $selected_letter === $letter ? 'active' : '' ?>">
                <?= $letter ?>
            </a>
        <?php endforeach; ?>
        <a href="../pagini/borrow_book.php" class="<?= empty($selected_letter) ? 'active' : '' ?>">Toate</a>
    </div>

    <!-- Lista cartilor -->
    <form action="../admin/lend_book.php" method="post">
        <div class="form-group">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th></th>
                        <th>Titlu</th>
                        <th>ISBN</th>
                        <th>Autori</th>
                        <th>Numar exemplare</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($books)): ?>
                        <?php foreach ($books as $book): ?>
                            <tr>
                                <td><input type="checkbox" name="book_ids[]" value="<?= $book['book_id'] ?>"></td>
                                <td><?= htmlspecialchars($book['title']) ?></td>
                                <td><?= htmlspecialchars($book['isbn']) ?></td>
                                <td><?= htmlspecialchars($book['authors']) ?></td>
                                <td><?= htmlspecialchars($book['no_of_copies']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">
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

        <input type="submit" class="btn btn-primary" name="lendBook" value="Acorda imprumut"></input>
    </form>

    <div class="cancel-borrow">
        <p>Apasati butonul <strong>Anuleaza</strong> pentru eliminarea detaliilor despre utilizator.</p>
        <form action="../admin/lend_book.php" method="post"> <input type="submit" class="btn btn-primary" name="lendCancel" value="Anuleaza"></input></form>
    </div>
</div>