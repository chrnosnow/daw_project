<?php
define('ALLOWED_ACCESS', true);
require __DIR__ . '/../lib/common.php';

// verifica daca timpul sesiunii a expirat
check_session_expiry();
// actualizeaza ultima activitate
$_SESSION['last_activity'] = time();
?>

<!DOCTYPE html>
<html lang="ro">

<head>
    <?php view('head', ['title' => 'Rezultatele cautarii'])
    ?>

    <meta name="keywords" content="biblioteca, atena, mica bufnita, carti, catalog" />
    <meta name="description"
        content='Cartile din catalogul Bibliotecii "Mica bufnita a Atenei"' />
    <link rel="stylesheet" href="../resurse/css/books_admin.css" type="text/css">

    <style>
        .container {
            margin-bottom: 4rem;
            padding: 15px;
            padding-left: calc(10 * var(--dim-spatiere));
        }
    </style>

</head>

<?php
require_once __DIR__ . '/../fragmente/header.php';
?>

<?php if (!empty($_GET['search'])) {

    include '../book/search.php';
} else {
    redirect_to('../index.php');
}
?>
</main>
</body>
<?php
require_once __DIR__ . '/../fragmente/footer.php';
?>

</html>