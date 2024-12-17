<?php
require __DIR__ . '/../lib/common.php';
?>

<!DOCTYPE html>
<html lang="ro">

<head>
    <?php view('head', ['title' => 'Cautare catalog'])
    ?>


    <meta name="keywords" content="biblioteca, atena, mica bufnita, rezultate, cautare" />

    <link rel="stylesheet" href="../resurse/css/authentication.css" type="text/css" />
    <link rel="stylesheet" href="../resurse/css/search.css" type="text/css" />
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
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">Bibliotecă</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Acasă</a></li>
                    <li class="nav-item"><a class="nav-link" href="books.php">Cărți</a></li>
                </ul>
                <form class="form-inline my-2 my-lg-0" method="get" action="">
                    <input class="form-control mr-sm-2" type="search" name="query" placeholder="Caută cărți sau autori..."
                        aria-label="Search" ">
                    <button class=" btn btn-outline-success my-2 my-sm-0" type="submit">Caută</button>
                </form>
            </div>
        </nav>

    </header>
    <main>
        <div class="container mt-4">
            <h1>Bine ai venit la Biblioteca noastră!</h1>
            <p>Aici vei găsi o mulțime de cărți interesante.</p>

            <!-- Afișează rezultatele căutării -->
            <?php include __DIR__ . "/../book/search.php"; ?>
        </div>


    </main>
</body>

</html>