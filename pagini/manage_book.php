<?php
require __DIR__ . '/../lib/common.php';
?>

<!DOCTYPE html>
<html lang="ro">

<head>
    <?php view('head', ['title' => 'Gestiune carti'])
    ?>


    <meta name="keywords" content="biblioteca, atena, mica bufnita" />
    <meta name="description"
        content='Adauga o carte in biblioteca MBA' />

    <link rel="stylesheet" href="../resurse/css/authentication.css" type="text/css" />
    <link rel="stylesheet" href="../resurse/css/books.css" type="text/css" />
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
        <div class="form-wrapper">
            <div>
                <h1>Adauga o carte</h1>
            </div>

            <?php
            if (isset($_SESSION['errors_add_book'])) {
            ?>
                <div class="errors">
                    <?php
                    display_alert('errors_add_book');
                    ?>
                </div>
            <?php
            } elseif (isset($_SESSION['book_added'])) {
            ?>
                <div class="success">
                <?php
                display_alert('book_added');
            } ?>
                </div>
                <?php
                include __DIR__ . "/../fragmente/book_form.php";
                ?>
        </div>
    </main>
</body>

</html>