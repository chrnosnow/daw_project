<?php
require __DIR__ . '/../admin/return_book_fees.php';
$user = $_SESSION['borrowing_user'] ?? null;
?>
<div class="container mt-4 wrapper-book">
    <h3>Introdu datele despre utilizator</h3>
    <form action="" method="post">
        <input type="hidden" name="token_processing" value="<?= generate_form_token() ?>">

        <?php if ($user) { ?>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" readonly>
            </div>
            <div class="form-group">
                <label for="card_no">Numar permis</label>
                <input type="text" class="form-control" id="library_card" name="library_card" value="<?= htmlspecialchars($user['card_no']) ?>" readonly>
            </div>
        <?php } else { ?>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" class="form-control" id="email" name="email">
            </div>
            <div class="form-group">
                <label for="card_no">Numar permis</label>
                <input type="text" class="form-control" id="library_card" name="library_card">
            </div>
        <?php } ?>
        <input type="submit" class="btn btn-primary" name="returnUser" value="Cauta"></input>
    </form>
</div>

<?php if (!empty($user)): ?>
    <form action="" method="post">
        <input type="hidden" name="token_processing" value="<?= generate_form_token() ?>">

        <input type="submit" class="btn btn-primary" name="refreshUser" value="Actualizeaza informatii"></input>
    </form>

    <div class="late-fees">
        <h3>Sumar utilizator</h3>
        <?php if (!empty($user['borrowed_count'])): ?>
            <p>Carti imprumutate: <?= $user['borrowed_count'] ?>.</p>
        <?php endif; ?>
        <p>Datorii: <strong><span style="font-size: 2rem;"><?= number_format($user['late_fee'], 2) ?></span></strong> lei.</p>
    </div>
    <div class="available-books">
        <div>
            <h3>Lista cartilor de returnat</h3>
        </div>
        <form action="" method="post">
            <div class="form-group">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Titlu</th>
                            <th>ISBN</th>
                            <th>Autori</th>
                            <th>Data scadentei</th>
                            <th>Zile intarziere</th>
                            <th>Penalitati (Lei)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($books_fees)): ?>
                            <?php foreach ($books_fees as $row): ?>
                                <tr>
                                    <td><input type="checkbox" name="books_ids[]" value="<?= $row['book_id'] ?>"></td>
                                    <td><?= htmlspecialchars($row['title']) ?></td>
                                    <td><?= htmlspecialchars($row['isbn']) ?></td>
                                    <td><?= htmlspecialchars($row['authors']) ?></td>
                                    <td><?= htmlspecialchars($row['due_date']) ?></td>
                                    <td><?= $row['days_late'] ?></td>
                                    <td><?= number_format($row['late_fee'], 2) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7">
                                    <p class="text-center">Utilizatorul nu are carti imprumutate.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <input type="submit" class="btn btn-primary" name="returnBook" value="Returneaza"></input>
        </form>

        <div class="cancel-return">
            <p>Apasati butonul <strong>Anuleaza</strong> pentru eliminarea detaliilor despre utilizator.</p>
            <form action="../admin/return_book_fees.php" method="post">
                <input type="hidden" name="token_processing" value="<?= generate_form_token() ?>">
                <input type="submit" class="btn btn-primary" name="returnCancel" value="Anuleaza"></input>
            </form>
        </div>
    </div>
<?php endif; ?>