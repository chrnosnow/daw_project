<?php
define('ALLOWED_ACCESS', true);

require __DIR__ . '/lib/common.php';
?>

<!DOCTYPE html>
<html lang="ro">

<head>
    <title>Mica Bufnita a Atenei</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="author" content="Irina Chihaitei" />
    <meta
        name="keywords"
        content="biblioteca, atena, mica bufnita, mitologie, carti" />
    <meta
        name="description"
        content='Bine ati venit pe pagina oficiala a Bibliotecii "Mica bufnita a Atenei" din Iasi - biblioteca pentru cei mari si cei mici' />


    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">

    <link rel="icon" type="image/png" href="./resurse/favicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="./resurse/favicon/favicon.svg" />
    <link rel="shortcut icon" href="./resurse/favicon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="./resurse/favicon/apple-touch-icon.png" />
    <meta name="apple-mobile-web-app-title" content="Mica Bufnita" />
    <link rel="manifest" href="./resurse/favicon/site.webmanifest" />

    <link rel="stylesheet" href="./resurse/css/reset.css" type="text/css" />
    <link rel="stylesheet" href="./resurse/css/customizare-bootstrap.css" type="text/css">
    <link rel="stylesheet" href="./resurse/css/general.css" type="text/css" />
    <link rel="stylesheet" href="./resurse/css/style.css" type="text/css" />
    <link rel="stylesheet" href="./resurse/css/nav.css" type="text/css" />
    <link rel="stylesheet" href="./resurse/css/nav1200.css" type="text/css" media="screen and (max-width:1200px)" />
    <link rel="stylesheet" href="./resurse/css/nav800.css" type="text/css" media="screen and
    (max-width:800px)" />
    <link rel="stylesheet" href="./resurse/css/search.css" type="text/css">
    <link rel="stylesheet" href="./resurse/css/nav_user.css" type="text/css">
    <link rel="stylesheet" href="./resurse/css/profile.css" type="text/css">
    <link rel="stylesheet" href="./resurse/css/books.css" type="text/css" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" />

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
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

<body>
    <header>
        <div class="inside-header">
            <div class="linkuri-sus">
                <ul>
                    <?php
                    if (is_user_logged_in()) {
                    ?>
                        <li><a href="./user/login.php"><i class="fa-solid fa-user"></i></a></li>
                        <li><a href="./pagini/logout.php">Deconectare</a></li>
                    <?php
                    } else {
                    ?>
                        <li><a href="./pagini/auth.php">Cont utilizator</a></li>
                    <?php } ?>
                    <li><a href="./pagini/books_catalog.php?search=all">Catalog carti</a></li>
                    <li><a href="./pagini/contact_us.php">Contact</a></li>
                </ul>
            </div>
            <div class="site-logo">
                <a href="index.php" rel="home">
                    <picture class="header-logo">
                        <source srcset="./resurse/imagini/logo_mba_800.avif" media="(max-width:800px)" />
                        <img alt="Biblioteca Mica bufnita a Atenei" src="./resurse/imagini/logo_mba.avif" />
                    </picture>
                </a>
            </div>
            <div class="container-meniu">
                <nav id="meniu-principal">
                    <label id="hamburger" for="ch-menu">
                        <span id="hamburger-text">MENU</span>
                        <span id="hamburger-bars">
                            <span id="bar1"></span>
                            <span id="bar2"></span>
                            <span id="bar3"></span>
                        </span>
                    </label>
                    <input id="ch-menu" type="checkbox" />
                    <ul class="meniu">
                        <li>
                            <div class="drop-down ls-meniu" id="acasa">ACASA</div>
                            <div class="drop-down ls-meniu" id="acasa-mediu">
                                <span class="fas fa-regular fa-house"></span>
                            </div>
                            <ul class="ls-meniu">
                                <li><a href="/#anunturi">EVENIMENTE</a></li>
                                <li><a href="/#program-lucru">PROGRAM</a></li>
                                <li><a href="/#recomandari-video">RECOMANDARI</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="/#main-menu-produse" class="drop-down ls-meniu">SERVICII</a>
                            <ul>
                                <li><a href="#">Toate</a></li>
                            </ul>
                        </li>
                        <li class="ls-meniu bara-meniu">
                            <a href="#">INREGISTRARE</a>
                        </li>
                        <li>
                            <div class="drop-down ls-meniu">DESPRE</div>
                            <ul>
                                <li><a href="#">Cine suntem?</a></li>
                                <li><a href="#">Intrebari frecvente</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
            <p id="watermark" style="display: none">Chihaitei<br />Irina</p>
        </div>
    </header>

    <main>
        <div id="grid-pagina">
            <section>
                <div class="img-search container mt-4">
                    <form action="./pagini/list_books.php" method="get" class="mb-3">
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
</main>
<footer id="footer">
    <a href="./index.php" id="link-inceput-footer">Acasa</a>
    <address id="adresa-footer">
        Bulevardul Colinelor Intortocheate, nr. 7, Iasi, Romania<br />
        <a href="https://maps.app.goo.gl/LSpKgaf9L1aU4NM87" target="_blank">Google Maps</a><br />
        <i class="fa-solid fa-phone"></i><a href="tel:+40701010101">Telefon</a><br />
        <a href="email:morosanu.irina@gmail.com">E-mail</a><br />
        <a href="whataspp:https://wa.me/10756985223">Whatsapp</a><br />
    </address>
    <small id="copyright-footer">Copyright &copy;
        <time datetime="2024-10-31 15:18">joi, 31 octombrie 2024</time>
    </small>
    <?php if ($show_banner): ?>
        <div id="container-banner">
            <form action="../lib/accept_cookies.php" method="POST">
                <input type="hidden" name="token_processing" value="<?= generate_form_token() ?>">
                <p id="cookie-banner">
                    Acesta este un proiect scolar.<span id="mesaj-cookies">
                        Acceptati cookie-urile de pe site?
                        <button id="ok_cookies" name="ok_cookies">Ok</button></span>
                </p>
            </form>
        </div>
    <?php endif; ?>
</footer>

<script>
    // reseteaza formularul la incarcarea paginii
    window.addEventListener('pageshow', function(event) {
        document.getElementById('form').reset();
    });

    // cookies
    document.addEventListener('DOMContentLoaded', function() {
        const cookieBanner = document.getElementById('cookie-banner');
        const acceptButton = document.getElementById('ok_cookies');

        if (!document.cookie.split('; ').find(row => row.startsWith('cookies_accepted='))) {
            document.getElementById("cookie-banner").style.display = 'block';
        }
        // Afișează banner-ul dacă există
        if (cookieBanner) {
            cookieBanner.style.display = 'block';

            // Când utilizatorul apasă "Accept"
            acceptButton.addEventListener('click', function() {
                fetch('./lib/accept_cookies.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            cookieBanner.style.display = 'none';
                        }
                    });
            });
        }
    });
</script>
</body>

</html>