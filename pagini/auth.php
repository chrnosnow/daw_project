<?php
require __DIR__ . '/../lib/common.php';
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
          <form action="auth.php">
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
          <?php
          if (isset($_SESSION['registration_success'])) {
            echo '<div class="registration_success">' .
              '<p>' . $_SESSION['registration_success'] . '</p>' .
              '</div>';
            unset($_SESSION['registration_success']);
          }
          if (isset($errors['uniq_email'])) {
            echo '<div class="error-uniq-email">' .
              '<p>' . $errors['uniq_email'] . '</p>' .
              '</div>';
            unset($errors['uniq_email']);
          }
          if (isset($errors['uniq_username'])) {
            echo '<div class="error-uniq-uname">' .
              '<p>' . $errors['uniq_username'] . '</p>' .
              '</div>';
            unset($errors['uniq_username']);
          }
          if (isset($errors['all_required'])) {
            echo '<div class="error-uniq-email">' .
              '<p>' . $errors['all_required'] . '</p>' .
              '</div>';
            unset($errors['all_required']);
          }
          ?>
          <form action="../user/register.php" method="post" autocomplete="off">
            <!-- <div class="input-box">
              <span class="icon"><i class="fa-solid fa-user"></i></span>
              <input type="text" name="lname" required />
              <label>Nume</label>
            </div>
            <div class="input-box">
              <span class="icon"><i class="fa-solid fa-user"></i></span>
              <input type="text" name="fname" required />
              <label>Prenume</label>
            </div> -->
            <div class="input-box">
              <span class="icon"><i class="fa-solid fa-user-tag"></i></span>
              <input type="text" name="uname" />
              <label>Nume utilizator*</label>
              <?php
              if (isset($errors['username_required'])) {
                echo '<div class="error">' .
                  '<p>' . $errors['username'] . '</p>' .
                  '</div>';
                unset($errors['username_required']);
              }

              if (isset($errors['username_len'])) {
                echo '<div class="error">' .
                  '<p>' . $errors['username_len'] . '</p>' .
                  '</div>';
                unset($errors['username_len']);
              }

              if (isset($errors['username_alphanum'])) {
                echo '<div class="error">' .
                  '<p>' . $errors['username_alphanum'] . '</p>' .
                  '</div>';
                unset($errors['username_alphanum']);
              }

              ?>
            </div>
            <div class="input-box">
              <span class="icon"><i class="fa-solid fa-envelope"></i></span>
              <input type="email" name="email" />
              <label>Email*</label>
              <?php
              if (isset($errors['email_required'])) {
                echo '<div class="error">' .
                  '<p>' . $errors['email_required'] . '</p>' .
                  '</div>';
                unset($errors['email_required']);
              }
              if (isset($errors['email'])) {
                echo '<div class="error">' .
                  '<p>' . $errors['email'] . '</p>' .
                  '</div>';
                unset($errors['email']);
              }
              ?>
            </div>
            <div class="input-box">
              <span class="icon"><i class="fa-solid fa-lock"></i></span>
              <input type="password" name="pass" />
              <label>Parola*</label>
              <?php
              if (isset($errors['passw'])) {
                echo '<div class="error">' .
                  '<p>' . $errors['passw'] . '</p>' .
                  '</div>';
                unset($errors['passw']);
              }
              ?>
            </div>
            <div class="input-box">
              <span class="icon"><i class="fa-solid fa-lock"></i></span>
              <input type="password" name="pass2" />
              <label>Confirma parola*</label>
              <?php
              if (isset($errors['passw2'])) {
                echo '<div class="error">' .
                  '<p>' . $errors['passw2'] . '</p>' .
                  '</div>';
                unset($errors['passw2']);
              }
              ?>
            </div>
            <div class="remember-forgot">
              <label><input type="checkbox" />Sunt de acord cu Termenii si
                conditiile si cu Politica de confidentialitate
              </label>
            </div>

            <button type="submit" class="btn" name="signup">Creeaza cont</button>
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