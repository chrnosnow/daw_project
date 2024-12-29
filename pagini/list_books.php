<?php
require __DIR__ . '/../lib/common.php';
?>

<!DOCTYPE html>
<html lang="ro">

<head>
    <?php view('head', ['title' => 'Rezultatele cautarii'])
    ?>

    <meta name="keywords" content="biblioteca, atena, mica bufnita, carti, catalog" />
    <meta name="description"
        content='Cartile din catalogul Bibliotecii "Mica bufnita a Atenei"' />
</head>

<body>
    <header>
        <div class="site-logo">
            <a href="../" rel="home">
                <picture class="header-logo">
                    <source srcset="../resurse/imagini/logo_mba_800.avif" media="(max-width:800px)" />
                    <img alt="Biblioteca Mica bufnita a Atenei" src="../resurse/imagini/logo_mba.avif" />
                </picture>
            </a>
        </div>
    </header>
    <main>
        <?php if (!empty($_GET['search'])) {

            include '../book/search.php';
        } else {
            redirect_to('../index.php');
        }
        ?>
    </main>
</body>

</html>