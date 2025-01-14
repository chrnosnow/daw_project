<?php
define('ALLOWED_ACCESS', true);


require __DIR__ . '/../lib/common.php';

$quotes = [
  [
    'citat' =>  'Foaie verde di-on dudău,<br />
                  Nimarui nu-i pare rău<br />
                  Dupa dorul cia-l duc eu.<br />
                  Nimarui nu-i ieste milă<br />
                  Di-al meu trai fără hodină,<br />
                  Că vărs sînge pentru țară<br />
                  Și petrec o viaț-amară.<br />',
    'autor' => 'Costan Vaman Lucan',
    'opera' => 'Cântece cătunești din Război din anul 1914-15'
  ],
  [
    'citat' =>  'Și aici <br />
                  în iarba umedă <br />
                  o jumătate de coajă <br />
                  a unui ou de prihor <br />
                  strălucește <br />
                  albastru ca o stea nou-născută <br />
                  fragilă ca o lume. <br />',
    'autor' => 'Maria Popova',
    'opera' => 'Vrajă împotriva indiferenței'
  ],
  [
    'citat' =>  'Dar cel mai ciudat lucru era încă altceva: spirala cochiliei sale s-a încolăcit în direcția opusă față de ceilalți melci - a spiralat la stânga și nu la dreapta, în aceeași direcție în care se târăște Pământul în jurul Soarelui. Bătrânul ridică tandru melcul mic și se minună de el.',
    'autor' => 'Maria Popova',
    'opera' => 'Melcul cu inima dreaptă'
  ],
  [
    'citat' =>  'Negreşit, oamenii sunt şi buni şi răi, dar e necesar să se precizeze în ce împrejurări. Trei nule puse înaintea cifrei una sau după ea, nu înseamnă acelaşi lucru.',
    'autor' => 'Camil Petrescu',
    'opera' => 'Ultima noapte de dragoste, întâia noapte de război'
  ],
  [
    'citat' =>  'Dragostea mea nu-i nici rătăcire, nici zigzag de încântare supremă şi disperări fără fund. Iubesc cum respir: egal, iremediabil şi pentru totdeauna…',
    'autor' => 'Cella Serghi',
    'opera' => 'Cartea Mironei'
  ],
  [
    'citat' =>  'Cred în liberul arbitru. Dacă câinele meu alege să poarte pica față de întreaga rasă umană, cu excepția mea, trebuie să aiba libertatea să o facă.',
    'autor' => 'Diana Wynne Jones',
    'opera' => 'Castelul din aer'
  ],
  [
    'citat' =>  'Nu sunt o pasăre; și nicio plasă nu mă va prinde; Sunt o ființă umană liberă, cu voință independentă; pe care acum o voi exercita ca să te părăsesc. &#10075;Eu nu sunt un înger&#10076;, am afirmat; și nu voi fi unul până nu voi muri: voi fi eu însămi.',
    'autor' => 'Charlotte Bronte',
    'opera' => 'Jane Eyre'
  ],
];

$todays_quote = generate_random_quote($quotes);
?>

<!DOCTYPE html>
<html lang="ro">

<head>
  <?php view('head', ['title' => 'Cont utilizator'])
  ?>


  <meta name="keywords" content="biblioteca, atena, mica bufnita, autentificare, utilizator" />
  <meta name="description"
    content='Vrei sa ai acces la cartile Bibliotecii "Mica bufnita a Atenei" din Iasi? Hai sa-ti faci un cont de utilizator!' />

  <link rel="stylesheet" href="../resurse/css/authentication.css" type="text/css" />
  <style>
    .site-logo {
      width: 50vw;
    }
  </style>
</head>

<body>
  <header>
    <div class="site-logo">
      <a href="../index.php" rel="home">
        <picture class="header-logo">
          <source srcset="../resurse/imagini/logo_mba_800.avif" media="(max-width:800px)" />
          <img alt="Biblioteca Mica bufnita a Atenei" src="../resurse/imagini/logo_mba.avif" />
        </picture>
      </a>
    </div>
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
          <?php
          if (isset($_SESSION['errors_login'])) {
            display_alert('errors_login');
          }
          if (isset($_SESSION['registration'])) {
            display_alert('registration');
          }
          ?>
          <form id="form" action="../user/login.php" method="post" autocomplete="off">
            <div class="input-box">
              <span class="icon"><i class="fa-solid fa-user"></i></span>
              <input type="text" placeholder=" " name="uname" />
              <label>Nume utilizator*</label>
            </div>
            <div class="input-box">
              <span class="icon"><i class="fa-solid fa-lock"></i></span>
              <input type="password" placeholder=" " name="pass" />
              <label>Parola*</label>
            </div>
            <!-- <div class="remember-forgot">
              <label><input type="checkbox" />Tine-ma minte</label>
              <a href="#">Ai uitat parola?</a>
            </div> -->
            <div class="g-recaptcha" data-sitekey="6LcJwK8qAAAAAPI7kG1_uzec48Ong5rTHkWQMzsb"></div>
            <input type="submit" class="btn" name="signin" value="Accesare cont"></input>
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
          <?php
          if (isset($_SESSION['errors'])) {
            display_alert('errors');
          }
          if (isset($_SESSION['errors_activation'])) {
            display_alert('errors_activation');
          }
          if (isset($_SESSION['alerts'])) {
            display_alert('alerts');
          }
          ?>
          <form id="form" class="register-form" action="../user/register.php" method="post" autocomplete="off">
            <input type="hidden" name="token_processing" value="<?= generate_form_token() ?>">
            <div class="input-box">
              <span class="icon"><i class="fa-solid fa-user-tag"></i></span>
              <input type="text" name="uname" placeholder=" " />
              <label>Nume utilizator*</label>

            </div>
            <div class="input-box">
              <span class="icon"><i class="fa-solid fa-envelope"></i></span>
              <input type="email" name="email" placeholder=" " />
              <label>Email*</label>

            </div>
            <div class="input-box">
              <span class="icon"><i class="fa-solid fa-lock"></i></span>
              <input type="password" name="pass" placeholder=" " />
              <label>Parola*</label>

            </div>
            <div class="input-box">
              <span class="icon"><i class="fa-solid fa-lock"></i></span>
              <input type="password" name="pass2" placeholder=" " />
              <label>Confirma parola*</label>
            </div>
            <div class="gdpr-wrapper">
              <label><input type="checkbox" name="gdpr" />* Sunt de acord cu <a href="politica-de-confidentialitate.php"><b>Politica de confidentialitate</b></a>
              </label>
            </div>
            <div class="g-recaptcha" data-sitekey="6LcJwK8qAAAAAPI7kG1_uzec48Ong5rTHkWQMzsb"></div>

            <input type="submit" class="btn" name="signup" value="Creeaza cont"></input>
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
            <?= $todays_quote['citat'] ?>
          </blockquote>
          <b><?= $todays_quote['autor'] ?></b>
          <cite><?= $todays_quote['opera'] ?></cite>
        </div>
      </div>
    </div>
  </main>
</body>

</html>