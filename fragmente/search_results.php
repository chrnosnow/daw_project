<div class="container mt-4">
    <?php if (!empty($_GET['query'])): ?>
        <h1>Rezultatele cautarii</h1>
    <?php endif; ?>
    <form method="get" class="mb-3">
        <div class="form-group">
            <input type="text" class="form-control" name="query" placeholder="Cauta in catalog...">
        </div>
        <button type="submit" class="btn btn-primary">Cauta
        </button>
    </form>

    <?php if (!empty($_GET['query'])): ?>
        <?php if (!empty($books)): ?>
            <div class="row">
                <?php
                $j = $offset;
                while ($j < $total_books) : ?>
                    <div class="col-md-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($books[$j]['title']) ?></h5>
                                <p class="card-text"><strong>ISBN:</strong> <?= htmlspecialchars($books[$j]['isbn']) ?></p>
                                <p class="card-text"><strong>Autori:</strong> <?= htmlspecialchars($books[$j]['authors']) ?></p>
                            </div>
                            <div class="card-footer">
                                <a href="edit_book.php?id=<?= $books[$j]['book_id'] ?>" class="btn btn-warning btn-sm">Editeaza</a>
                                <a href="delete_book.php?id=<?= $books[$j]['book_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Esti sigur ca vrei sa stergi aceasta carte?')">Sterge</a>
                            </div>
                        </div>
                    </div>
                    <?php
                    $j++;
                    if ($j % $results_per_page === 0)
                        break;
                    ?>
                <?php endwhile; ?>
            </div>

            <!-- Paginare -->
            <nav>
                <ul class="pagination">
                    <?php if ($current_page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?query=<?= urlencode($search_term) ?>&page=<?= $current_page - 1 ?>">Inapoi</a>
                        </li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?= $i === $current_page ? 'active' : '' ?>">
                            <a class="page-link" href="?query=<?= urlencode($search_term) ?>&page=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($current_page < $total_pages): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $current_page + 1 ?>">Inainte</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>

        <?php else:
            if (isset($_SESSION['errors_search'])) {
                display_alert('errors_search');
            }
        endif; ?>
    <?php endif; ?>
</div>