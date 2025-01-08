<div class="container mt-4">
    <?php if (!empty($_GET['search'])): ?>
        <h1>Rezultatele cautarii</h1>
    <?php endif; ?>
    <form method="get" class="mb-3">
        <div class="form-group">
            <input type="text" class="form-control" name="search" placeholder="Cauta in catalog...">
        </div>
        <button type="submit" class="btn btn-primary">Cauta
        </button>
    </form>

    <?php if (!empty($_GET['search'])): ?>
        <?php if (!empty($books)): ?>
            <div class="row">
                <?php
                $j = $offset;
                while ($j < $total_books) : ?>
                    <div class="col-md-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title"><a href="../pagini/book_details.php?id=<?= $books[$j]['book_id'] ?>" target="_blank"><?= htmlspecialchars($books[$j]['title']) ?></a></h5>
                                <p class="card-text"><strong>ISBN:</strong> <?= htmlspecialchars($books[$j]['isbn']) ?></p>
                                <p class="card-text"><strong>Autori:</strong> <?= htmlspecialchars($books[$j]['authors']) ?></p>
                                <?php if (is_user_logged_in()): ?>
                                    <p class="card-text"><strong>Numar exemplare disponibile:</strong> <?= htmlspecialchars($books[$j]['no_of_copies']) ?></p>
                                <?php endif; ?>
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
                            <a class="page-link" href="?search=<?= urlencode($search_term) ?>&page=<?= $current_page - 1 ?>">Inapoi</a>
                        </li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?= $i === $current_page ? 'active' : '' ?>">
                            <a class="page-link" href="?search=<?= urlencode($search_term) ?>&page=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($current_page < $total_pages): ?>
                        <li class="page-item">
                            <a class="page-link" href="?search=<?= urlencode($search_term) ?>&page=<?= $current_page + 1 ?>">Inainte</a>
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