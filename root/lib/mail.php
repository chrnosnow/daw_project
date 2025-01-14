<?php
require_once __DIR__ . '/../config/mail_config.php';
require_once __DIR__ . '/../module/phpmailer/class.phpmailer.php';


function send_mail($email, $nume, $subject, $message, $alt_message = 'To view this post you need a compatible HTML viewer!')
{
    $mail = new PHPMailer(true);

    $mail->IsSMTP();

    // În caz că vreun rând depășește N caractere, trebuie să utilizăm
    // wordwrap()
    $message = wordwrap($message, 360, "<br />\n");

    try {

        $mail->SMTPDebug  = 0;
        /* 
      Setting the SMTPAuth property to true, so we can use 
      our Gmail login	details to send the mail.
   */
        $mail->SMTPAuth   = true;

        $mail->SMTPSecure = 'ssl';
        $mail->Host       = MAIL_HOST;
        $mail->Port       = 465;
        $mail->Username   = MAIL_USERNAME;        // GMAIL username
        $mail->Password   = MAIL_PASSWORD;        // GMAIL password (aka token from App passwords)

        //where the email goes
        $mail->AddAddress($email, $nume);
        //The 'addReplyTo' property specifies where the recipient can reply to.
        $mail->AddReplyTo(REPLY_TO, REPLY_TO_NAME);
        //who is sending the email
        $mail->SetFrom(SEND_FROM, SEND_FROM_NAME);
        $mail->Subject = $subject;
        $mail->MsgHTML($message);
        $mail->AddEmbeddedImage("../resurse/imagini/logo_mba.jpg", "mba-logo", "logo_mba.jpg");
        //plain text alternative for when HTML content is not supported
        $mail->AltBody = $alt_message;

        $mail->Send();
    } catch (phpmailerException $e) {
        $_SESSION['errors']['PHPMailer_err'] = 'A aparut o eroare de la PHPMailer: ' . $e->errorMessage(); //error from PHPMailer
    } catch (Exception $e) {
        $_SESSION['errors']['mail_err'] = 'A aparut o eroare la trimiterea email-ului:' . $e->getMessage(); //error from anything else!
    }
}
