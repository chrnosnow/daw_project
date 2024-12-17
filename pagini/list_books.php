<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista cartilor</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .card {
            margin-bottom: 20px;
        }

        .card-body {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: bold;
        }

        .pagination {
            justify-content: center;
        }

        .alphabet-filter {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .alphabet-filter a {
            margin: 5px;
            padding: 10px 15px;
            text-decoration: none;
            border: 1px solid #007bff;
            border-radius: 5px;
            color: #007bff;
        }

        .alphabet-filter a.active,
        .alphabet-filter a:hover {
            background-color: #007bff;
            color: #fff;
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <h1 class="mb-4">Lista cartilor</h1>
        <a href="add_book.php" class="btn btn-primary mb-4">Adauga o carte</a>

        <!-- Filtrare Alfabetică -->
        <div class="alphabet-filter">
            <?php foreach (range('A', 'Z') as $letter): ?>
                <a href="?letter=<?= $letter ?>" class="<?= $selected_letter === $letter ? 'active' : '' ?>">
                    <?= $letter ?>
                </a>
            <?php endforeach; ?>
            <a href="list_books.php" class="<?= empty($selected_letter) ? 'active' : '' ?>">Toate</a>
        </div>

        <!-- Lista cărților -->
        <div class="row">
            <?php if (!empty($books)): ?>
                <?php foreach ($books as $book): ?>
                    <div class="col-md-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($book['title']) ?></h5>
                                <p class="card-text"><strong>ISBN:</strong> <?= htmlspecialchars($book['isbn']) ?></p>
                                <p class="card-text"><strong>Autori:</strong> <?= htmlspecialchars($book['authors']) ?></p>
                            </div>
                            <div class="card-footer">
                                <a href="edit_book.php?id=<?= $book['book_id'] ?>" class="btn btn-warning btn-sm">Editează</a>
                                <a href="delete_book.php?id=<?= $book['book_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Ești sigur că vrei să ștergi această carte?')">Șterge</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <p class="text-center">Nu s-au găsit carti pentru filtrul selectat.</p>
                </div>
            <?php endif; ?>
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
                        <a class="page-link" href="?letter=<?= $selected_letter ?>&page=<?= $current_page + 1 ?>">Înainte</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</body>

</html>