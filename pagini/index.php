<?php
define('ALLOWED_ACCESS', true);
require __DIR__ . '/common.php';
?>

<!DOCTYPE html>
<html lang="ro">

<head>
    <?php
    view('head', ['title' => 'Mica Bufnita a Atenei']);
    ?>
    <meta
        name="keywords"
        content="biblioteca, atena, mica bufnita, mitologie, carti" />
    <meta
        name="description"
        content='Bine ati venit pe pagina oficiala a Bibliotecii "Mica bufnita a Atenei" din Iasi - biblioteca pentru cei mari si cei mici' />

    <style>
        .container {
            max-width: unset;
        }

        .search-box {
            width: 450px;
        }

        .btn.search-btn {
            width: 60px;
        }

        .search-btn .fa-search {
            font-size: 28px;
            padding-left: 0;
            align-items: center;
        }
    </style>
</head>

<?php
require_once __DIR__ . '/../fragmente/header.php';
?>

<div id="grid-pagina">
    <section>
        <div class="img-search container mt-4">
            <form action="./list_books.php" method="get" class="mb-3">
                <div class="form-group">
                    <input type="text" class="form-control search-box" name="search" placeholder="Cauta in catalog...">
                </div>
                <button type="submit" class="btn btn-primary search-btn"><i class="fa fa-search"></i>
                </button>
            </form>
        </div>
    </section>

    <section id="home">
        <h2>Acasa</h2>
        <p>
            Bun venit in Biblioteca! Avem <b><i>carti</i></b> pentru toate gusturile si varstele.
        </p>
        <p>
            <em>Daca nu ati gasit</em> cartea cautata, ne puteti anunta si
            tragem sfori in tara si peste hotare sa facem rost de ea.
        </p>
    </section>
</div>
</main>
</body>
<?php
require_once __DIR__ . '/../fragmente/footer.php';
?>

</html>