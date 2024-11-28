<!DOCTYPE html>
<html lang="ro">

<head>
  <title>Mica bufnita a Atenei</title>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="author" content="Irina Chihaitei" />
  <meta name="keywords" content="biblioteca, atena, mica bufnita, autentificare, utilizator" />
  <meta name="description"
    content='Vrei sa ai acces la cartile Bibliotecii "Mica bufnita a Atenei" din Iasi? Hai sa-ti faci un cont de utilizator!' />

  <link rel="icon" type="image/png" href="../resurse/favicon/favicon-96x96.png" sizes="96x96" />
  <link rel="icon" type="image/svg+xml" href="../resurse/favicon/favicon.svg" />
  <link rel="shortcut icon" href="../resurse/favicon/favicon.ico" />
  <link rel="apple-touch-icon" sizes="180x180" href="../resurse/favicon/apple-touch-icon.png" />
  <meta name="apple-mobile-web-app-title" content="Mica Bufnita" />
  <link rel="manifest" href="../resurse/favicon/site.webmanifest" />

  <link rel="stylesheet" href="../resurse/css/reset.css" type="text/css" />
  <link rel="stylesheet" href="../resurse/css/general.css" type="text/css" />
  <link rel="stylesheet" href="../resurse/css/style.css" type="text/css" />
  <link rel="stylesheet" href="../resurse/css/authentication.css" type="text/css" />
  <link rel="stylesheet" href="../resurse/css/nav1200.css" type="text/css" media="screen and (max-width:1200px)" />
  <link rel="stylesheet" href="../resurse/css/nav800.css" type="text/css" media="screen and
    (max-width:800px)" />

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" />
</head>

<body>
  <header>
    <div class="site-logo">
      <a href="/" rel="home">
        <picture class="header-logo">
          <source srcset="../resurse/imagini/logo_mba_800.avif" media="(max-width:800px)" />
          <img alt="Biblioteca Mica bufnita a Atenei" src="../resurse/imagini/logo_mba.avif" />
        </picture>
      </a>
    </div>
    <p id="watermark" style="display: none">Chihaitei<br />Irina</p>
  </header>
  <main>
    <div class="wrapper">
      <div class="wrapper-user-account">
        <?php
        $form = $_GET['form'] ?? 'login';

        $loginClass = $form === 'login' ? '' : 'hidden';
        $registerClass = $form === 'register' ? '' : 'hidden';
        ?>

        <!-- Login form -->
        <div class="form-box login <?= $loginClass; ?>">
          <h2>Autentificare utilizator</h2>
          <form action="#">
            <div class="input-box">
              <span class="icon"><i class="fa-solid fa-user"></i></span>
              <input type="text" required />
              <label>Nume utilizator</label>
            </div>
            <div class="input-box">
              <span class="icon"><i class="fa-solid fa-lock"></i></span>
              <input type="password" required />
              <label>Parola</label>
            </div>
            <div class="remember-forgot">
              <label><input type="checkbox" />Tine-ma minte</label>
              <a href="#">Ai uitat parola?</a>
            </div>
            <button type="submit" class="btn">Accesare cont</button>
            <div class="login-register">
              <p>
                Nu ai un cont?
                <a href="?form=register" class="register-link">Creeaza un cont nou</a>
              </p>
            </div>
          </form>
        </div>

        <!-- Registration form -->
        <div class="form-box register <?= $registerClass; ?>">
          <h2>Inregistrare</h2>
          <form action="#">
            <div class="input-box">
              <span class="icon"><i class="fa-solid fa-user"></i></span>
              <input type="text" required />
              <label>Nume</label>
            </div>
            <div class="input-box">
              <span class="icon"><i class="fa-solid fa-user"></i></span>
              <input type="text" required />
              <label>Prenume</label>
            </div>
            <div class="input-box">
              <span class="icon"><i class="fa-solid fa-user-tag"></i></span>
              <input type="text" required />
              <label>Nume utilizator</label>
            </div>
            <div class="input-box">
              <span class="icon"><i class="fa-solid fa-envelope"></i></span>
              <input type="email" required />
              <label>Email</label>
            </div>
            <div class="input-box">
              <span class="icon"><i class="fa-solid fa-lock"></i></span>
              <input type="password" required />
              <label>Parola</label>
            </div>
            <div class="remember-forgot">
              <label><input type="checkbox" />Sunt de acord cu Termenii si
                conditiile si cu Politica de confidentialitate
              </label>
            </div>
            <button type="submit" class="btn">Creeaza cont</button>
            <div class="login-register">
              <p>
                Ai deja un cont?
                <a href="?form=login" class="login-link">Accesare cont</a>
              </p>
            </div>
          </form>
        </div>
      </div>
      <div class="wrapper-quote">
        <div class="quote-card">
          <blockquote>
            Foaie verde di-on dudău,<br />
            Nimarui nu-i pare rău<br />
            Dupa dorul cia-l duc eu.<br />
            Nimarui nu-i ieste milă<br />
            Di-al meu trai fără hodină,<br />
            Că vărs sînge pentru țară<br />
            Și petrec o viaț-amară.<br />
          </blockquote>
          <!-- <blockquote>
              Dar cel mai ciudat lucru era încă altceva: spirala cochiliei sale
              s-a încolăcit în direcția opusă față de ceilalți melci - a
              spiralat la stânga și nu la dreapta, în aceeași direcție în care
              se târăște Pământul în jurul Soarelui. Bătrânul ridică tandru
              melcul mic și se minună de el.
            </blockquote> -->
          <b>Costan Vaman Lucan</b>
          <cite>Cântece cătunești din Război din anul 1914-15</cite>
        </div>
      </div>
    </div>
  </main>
</body>

</html>