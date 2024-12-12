<?php
require __DIR__ . '/lib/common.php';
?>
<!DOCTYPE html>
<html lang="ro">

<head>
  <title>Mica bufnita a Atenei</title>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="author" content="Irina Chihaitei" />
  <meta
    name="keywords"
    content="biblioteca, atena, mica bufnita, mitologie, carti" />
  <meta
    name="description"
    content='Bine ati venit pe pagina oficiala a Bibliotecii "Mica bufnita a Atenei" din Iasi - biblioteca pentru cei mari si cei mici' />

  <link
    rel="icon"
    type="image/png"
    href="./resurse/favicon/favicon-96x96.png"
    sizes="96x96" />
  <link
    rel="icon"
    type="image/svg+xml"
    href="./resurse/favicon/favicon.svg" />
  <link rel="shortcut icon" href="./resurse/favicon/favicon.ico" />
  <link
    rel="apple-touch-icon"
    sizes="180x180"
    href="./resurse/favicon/apple-touch-icon.png" />
  <meta name="apple-mobile-web-app-title" content="Mica Bufnita" />
  <link rel="manifest" href="./resurse/favicon/site.webmanifest" />

  <link rel="stylesheet" href="./resurse/css/reset.css" type="text/css" />
  <link rel="stylesheet" href="./resurse/css/general.css" type="text/css" />
  <link rel="stylesheet" href="./resurse/css/style.css" type="text/css" />
  <link rel="stylesheet" href="./resurse/css/nav.css" type="text/css" />
  <link
    rel="stylesheet"
    href="./resurse/css/nav1200.css"
    type="text/css"
    media="screen and (max-width:1200px)" />
  <link
    rel="stylesheet"
    href="./resurse/css/nav800.css"
    type="text/css"
    media="screen and
    (max-width:800px)" />

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Lato&display=swap"
    rel="stylesheet" />
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" />
</head>

<body>
  <header>
    <div class="inside-header">
      <div class="linkuri-sus">
        <ul>
          <?php
          if (is_user_logged_in()) {
          ?>
            <li><a href="pagini/logout.php">Deconectare</a></li>
          <?php
          } else {
          ?>
            <li><a href="pagini/auth.php">Cont utilizator</a></li>
          <?php } ?>
          <li><a href="">Obține un permis</a></li>
          <li><a href="">Contact</a></li>
        </ul>
      </div>
      <div class="site-logo">
        <a href="/" rel="home">
          <picture class="header-logo">
            <source
              srcset="./resurse/imagini/logo_mba_800.avif"
              media="(max-width:800px)" />
            <img
              alt="Biblioteca Mica bufnita a Atenei"
              src="./resurse/imagini/logo_mba.avif" />
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
              <a href="/inregistrare">INREGISTRARE BIBLIOTECA</a>
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
  <main>
    <div id="grid-pagina">
      <section>
        <div class="img-search">
          <input
            class="search-box"
            type="text"
            name="lookfor"
            placeholder="Cautare in catalog..." />
          <button class="btn search-btn">
            <i class="fa fa-search"></i>
          </button>
        </div>
      </section>
      <section id="home">
        <h2>Acasa</h2>
        <p>
          Bun venit în Biblioteca! Avem <b><i>carti</i></b> și
          <b>reviste</b>-uri pentru toate gusturile și vârstele.
        </p>
        <p>
          <em>Dacă nu ați găsit</em> cartea căutata, ne puteți anunța și
          tragem sfori în țară și peste hotare să facem rost de ea.
        </p>
      </section>
    </div>
  </main>
  <footer id="footer">
    <a href="#" id="link-inceput-footer">Acasa</a>
    <a href="#" title="Hai inapoi sus" id="link-top">
      <div id="triunghi">&#129081;</div>
    </a>
    <address id="adresa-footer">
      Bulevardul Colinelor Intortocheate, nr. 2, Iasi, Romania<br />
      <a href="https://maps.app.goo.gl/LSpKgaf9L1aU4NM87" target="_blank">Google Maps</a><br />
      <i class="fa-solid fa-phone"></i><a href="tel:+40701010101">Telefon</a><br />
      <a href="email:office@vagaunacujocuri.ro">E-mail</a><br />
      <a href="whataspp:https://wa.me/10756985223">Whataspp</a><br />
    </address>
    <small id="copyright-footer">Copyright &copy;
      <time datetime="2024-10-31 15:18">joi, 31 octombrie 2024</time></small>
    <div id="container-banner">
      <p id="banner">
        Acesta este un proiect scolar.<span id="mesaj-cookies">
          Acceptati cookie-urile de pe site?
          <button id="ok_cookies">Ok</button></span>
      </p>
    </div>
  </footer>
</body>

</html>