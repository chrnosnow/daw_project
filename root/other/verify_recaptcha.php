<?php
require_once __DIR__ . '/../lib/common.php';

$success = [];
$errors = [];


if (is_post_req() && isset($_POST['submit'])) {
  $name = sanitize_text($_POST['uname']);
  $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
  $subject = sanitize_text($_POST['subject']);
  $message_to_admin = sanitize_text($_POST['content']);

  if (empty($name)) {
    $errors['name_required'] = sprintf(DEFAULT_VALIDATION_ERRORS['required'], "Campul NUME sau campul NUME UTILIZATOR");
  }
  if (empty($email)) {
    $errors['email_required'] = sprintf(DEFAULT_VALIDATION_ERRORS['required'], "Campul EMAIL");
  }

  if (!validate_email($email)) {
    $errors['valid_email'] = sprintf(DEFAULT_VALIDATION_ERRORS['email'], $email);
  }

  $user = get_user_by_email($email);
  if (empty($user)) {
    $errors['find_user'] = "Utilizatorul nu a putut fi gasit.";
  }

  //reCAPTCHA checkbox validation
  $recaptcha = $_POST['g-recaptcha-response'];
  $verify_response = verify_captcha($recaptcha);
  if ($verify_response->success) {
    $subject = "Formular contact: " . $subject;
    $message_to_admin = "Nume: " . $name . "<br>Email: " . $email . "<br>Mesaj: " . $message_to_admin;
    send_mail(SEND_FROM, '', $subject, $message_to_admin);
    if (empty($_SESSION['errors']['PHPMailer_err']) && empty($_SESSION['errors']['mail_err'])) {
      $sbj = "Am primit mesajul tau";
      $message_to_user = "
            <div>
            <table
              width='680'
              border='0'
              align='center'
              style='font-family: \'Lato\', sans-serif'
            >
              <tbody >
                <tr>
                  <td align='center' valign='center' style='background-style: #F9F9F9; padding:0 21px;'>
                    <img
                      alt='Biblioteca Mica bufnita a Atenei'
                      src='cid:mba-logo'
                      style='width: 200px; height: auto'
                    />
                  </td>
                </tr>
                <tr>
                  <td style='font-size: 1.2em'>
                    <p> Salutare, {$name}! </p><br />
                    <p>
                      Multumim pentru mesajul tau. Te vom contacta cat de curand.</p>
                    <p>Numai bine,</p>
                    <p>Echipa MBA</p>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        ";
      $alt_message = "Salutare, {$name}!\nMultumim pentru mesajul tau. Te vom contacta cat de curand.\n\nNumai bine,\nEchipa MBA";
      send_mail($email, $name, $sbj, $message_to_user, $alt_message);
      $success['mail_sent'] = "Mesajul a fost transmis cu succes.";
      $_SESSION['success'] = $success;
    }
    $_POST = [];
  } else {
    $errors['captcha_verify'] = 'Te rugam sa faci verificarea CAPTCHA.';
  }

  if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    redirect_to('../pagini/contact_us.php');
  }

  redirect_to('../pagini/contact_us.php');
} else {
  redirect_to("../index.php");
}
