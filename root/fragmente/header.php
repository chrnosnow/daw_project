<body>
    <header>
        <div class="inside-header">
            <div class="linkuri-sus">
                <ul>
                    <?php
                    if (is_user_logged_in()) {
                    ?>
                        <li><a href="../user/login.php"><i class="fa-solid fa-user"></i></a></li>
                        <li><a href="../pagini/logout.php">Deconectare</a></li>
                    <?php
                    } else {
                    ?>
                        <li><a href="../pagini/auth.php">Cont utilizator</a></li>
                    <?php } ?>
                    <li><a href="../pagini/books_catalog.php?search=all">Catalog carti</a></li>
                    <li><a href="../pagini/contact_us.php">Contact</a></li>
                </ul>
            </div>
            <div class="site-logo">
                <a href="../index.php" rel="home">
                    <picture class="header-logo">
                        <source srcset="../resurse/imagini/logo_mba_800.avif" media="(max-width:800px)" />
                        <img alt="Biblioteca Mica bufnita a Atenei" src="../resurse/imagini/logo_mba.avif" />
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
                                <li><a href="/produse">Toate</a></li>
                            </ul>
                        </li>
                        <li class="ls-meniu bara-meniu">
                            <a href="./auth.php?form=register">INREGISTRARE</a>
                        </li>
                        <li>
                            <div class="drop-down ls-meniu">DESPRE</div>
                            <ul>
                                <li><a href="/#despre-noi">Cine suntem?</a></li>
                                <li><a href="/#faq">Intrebari frecvente</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
            <p id="watermark" style="display: none">Chihaitei<br />Irina</p>
        </div>
    </header>
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
    <script>
        // cookies
        document.addEventListener('DOMContentLoaded', function() {
            if (!document.cookie.split('; ').find(row => row.startsWith('cookies_accepted='))) {
                document.getElementById("cookie-banner").style.display = 'block';
            }

            document.getElementById("ok_cookies").addEventListener('click', function() {
                fetch('../lib/accept_cookies.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: new URLSearchParams({
                        ok_cookies: '1'
                    })
                })
                then(() => {
                    document.getElementById("cookie-banner").style.display = 'none';
                }).catch(error => {
                    console.error('Eroare:', error);
                });
            });
        });
    </script>
    <main>