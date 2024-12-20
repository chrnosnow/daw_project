<?php
require_once __DIR__ . '/../lib/common.php';
$all_authors = execute_query_and_fetch("SELECT * FROM authors ORDER BY last_name"); //$all_authors[index][author_details]

$first_letter_and_authors = [];
foreach ($all_authors as $author) {
    $first_letter = strtoupper($author['last_name'][0]);
    $first_letter_and_authors[$first_letter][] = $author;
}
?>


<div class="container mt-4 wrapper-book">
    <form action="../book/add_book.php" method="post">
        <div class="form-group">
            <label for="title">Titlu*</label>
            <input type="text" class="form-control" id="title" name="title">
        </div>
        <div class="form-group">
            <label for="edition">Editie</label>
            <input type="text" class="form-control" id="edition" name="edition">
        </div>
        <div class="form-group">
            <label for="isbn">ISBN*</label>
            <input type="text" class="form-control" id="isbn" name="isbn">
        </div>
        <div class="form-group">
            <label for="publisher">Editura</label>
            <input type="text" class="form-control" id="publisher" name="publisher">
        </div>
        <div class="form-group">
            <label for="public_yr">An aparitie</label>
            <input type="text" class="form-control" id="public_yr" name="public_yr">
        </div>
        <div class="form-group">
            <label for="lang">Limba</label>
            <input type="text" class="form-control" id="lang" name="lang">
        </div>
        <div class="form-group">
            <label for="author_ids">Autori*</label>
            <select multiple class="form-control" id="author_ids" name="author_ids[]">
                <?php foreach ($first_letter_and_authors as $letter => $authors): ?>
                    <optgroup label=<?= $letter ?>>
                        <?php foreach ($authors as $author): ?>
                            <option value="<?= $author['id'] ?>">
                                <?= htmlspecialchars($author['first_name'] . ' ' . $author['last_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </optgroup>
                <?php endforeach; ?>
            </select>
            <small class="form-text text-muted">Tine apasata tasta CTRL pentru a selecta mai multi autori.</small>
        </div>
        <div class="form-group">
            <label for="new_authors">Sau adauga autori noi (prenume si nume, separate prin virgula):</label>
            <textarea class="form-control" id="new_authors" name="new_authors" rows="3"></textarea>
            <small class="form-text text-muted">Exemplu: Ioana Alexandra Popescu, Mario J.P. Vargas Llosa, Autor Necunoscut</small>
        </div>
        <button type="submit" class="btn btn-primary">Salveaza</button>
    </form>
</div>