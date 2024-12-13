<?php
require_once __DIR__ . '/../config/mail_config.php';
require_once __DIR__ . '/../module/phpmailer/class.phpmailer.php';


function send_mail($email, $nume = '', $subject, $message)
{
    $mail = new PHPMailer(true);

    $mail->IsSMTP();

    // În caz că vreun rând depășește N caractere, trebuie să utilizăm
    // wordwrap()
    $message = wordwrap($message, 160, "<br />\n");

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
        /*providing a plain text alternative to the HTML version of our email. 
          This is important for compatibility with email clients that may not support or display HTML content. 
          In such cases, the email client will display the plain text content instead of the HTML content.*/
        $mail->AltBody = 'To view this post you need a compatible HTML viewer!';
        $mail->Send();
        echo "Message Sent OK</p>\n";
    } catch (phpmailerException $e) {
        echo $e->errorMessage(); //error from PHPMailer
    } catch (Exception $e) {
        echo $e->getMessage(); //error from anything else!
    }
}
