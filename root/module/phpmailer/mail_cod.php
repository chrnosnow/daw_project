<?php

require_once('class.phpmailer.php');
require_once('mail_config.php');

// Mesajul
$message = "Mesajul ce va fi transmis";

// În caz că vreun rând depășește N caractere, trebuie să utilizăm
// wordwrap()
$message = wordwrap($message, 160, "<br />\n");


$mail = new PHPMailer(true);

$mail->IsSMTP();

try {

  $mail->SMTPDebug  = 0;
  $mail->SMTPAuth   = true;

  $to = 'morosanu.irina@gmail.com';
  $nume = 'Biblioteca "Mica Bufnita a Atenei"';

  $mail->SMTPSecure = "ssl";
  $mail->Host       = "smtp.gmail.com";
  $mail->Port       = 465;
  $mail->Username   = $username;        // GMAIL username
  $mail->Password   = $password;        // GMAIL password (aka token from App passwords)
  $mail->AddReplyTo('chrnosnow@gmail.com', 'snoq');

  //where the email goes
  $mail->AddAddress($to, $nume);
  //who is sending the email
  $mail->SetFrom('morosanu.irina@gmail.com', 'Biblioteca "Mica Bufnita a Atenei"');
  $mail->Subject = 'Test';
  /*providing a plain text alternative to the HTML version of our email. 
    This is important for compatibility with email clients that may not support or display HTML content. 
    In such cases, the email client will display the plain text content instead of the HTML content.*/
  $mail->AltBody = 'To view this post you need a compatible HTML viewer!';
  $mail->MsgHTML($message);
  $mail->Send();
  echo "Message Sent OK</p>\n";
} catch (phpmailerException $e) {
  echo $e->errorMessage(); //error from PHPMailer
} catch (Exception $e) {
  echo $e->getMessage(); //error from anything else!
}
