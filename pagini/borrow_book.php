<?php
require __DIR__ . '/../lib/common.php';

require_role(true);

// verifica daca timpul sesiunii a expirat
check_session_expiry();
// actualizeaza ultima activitate
$_SESSION['last_activity'] = time();

// Configurare paginatie
$results_per_page = 5;
$current_page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($current_page - 1) * $results_per_page;

// Obtinem litera selectată din URL
$selected_letter = $_GET['letter'] ?? '';

$where_clause = '';
$params = [];
$types = '';

if (!empty($selected_letter) && preg_match('/^[A-Za-z]$/', $selected_letter)) {
    $where_clause = "AND books.title LIKE ?";
    $params[] = $selected_letter . '%';
    $types .= 's';
}

// Obtinem numarul total de carti filtrate
$total_books_query = "SELECT COUNT(*) AS total FROM books WHERE no_of_copies > 0 $where_clause";
$total_books = execute_query_and_fetch($total_books_query, $types, $params)[0]['total'];
$total_pages = ceil($total_books / $results_per_page);

// Obtinem cartile pentru pagina curenta
$query = "
    SELECT books.id AS book_id, books.title, books.isbn, 
           GROUP_CONCAT(CONCAT(authors.first_name, ' ', authors.last_name) SEPARATOR ', ') AS authors, books.no_of_copies
    FROM books
    LEFT JOIN author_book ON books.id = author_book.book_id
    LEFT JOIN authors ON authors.id = author_book.author_id
    WHERE no_of_copies > 0 $where_clause
    GROUP BY books.id
    ORDER BY books.title ASC
    LIMIT ? OFFSET ?
";
$params[] = $results_per_page;
$params[] = $offset;
$types .= 'ii';

$books = execute_query_and_fetch($query, $types, $params);
?>

<!DOCTYPE html>
<html lang="ro">

<head>
    <?php
    view('head', ['title' => 'Acordare imprumut']);
    ?>
    <link rel="stylesheet" href="../resurse/css/books_admin.css" type="text/css">

    <style>
        .available-books {
            max-width: 100vw;
            height: auto;
        }

        input.form-control:read-only {
            color: grey;
        }

        .btn[name='lendCancel'] {
            background-color: var(--culoare-portocaliu);
        }

        .btn[name='lendCancel']:hover {
            background-color: var(--culoare-hover);
        }

        .cancel-borrow {
            color: brown;
            margin-top: 2rem;
            margin-bottom: 0.5rem;
        }

        .cancel-borrow p {
            margin-bottom: 0.5rem;
        }
    </style>
</head>

<?php
require_once __DIR__ . '/../fragmente/header_user.php';
?>

<div class="wrapper">
    <?php
    require_once __DIR__ . "/../fragmente/sidebar_user.php";
    ?>
    <div class="wrapper-user-account">
        <div class="title">
            <h2>Acordare imprumut</h2>
        </div>
        <?php
        if (isset($_SESSION['errors'])) {
            display_alert('errors');
        }
        if (isset($_SESSION['alerts'])) {
            display_alert('alerts');
        }
        if (isset($_SESSION['success'])) {
            display_alert('success');
        }
        ?>
        <?php include __DIR__ . "/../fragmente/borrow_book_form.php"; ?>
    </div>
</div>
</main>
</body>

</html>