<?php
// PHPMailer settings. --------------------------------------
/**
 *  Set your smtp server like `mail.domain.com`
 *  or `smtp.mailserver.com`.
 *  Example: If you want to send emails through Gmail 
 *  the syntax is `smtp.gmail.com`.
 *  If you you want to send emails from your website 
 *  the syntax is `mail.your-domain.com`.
 */
const MAIL_HOST = 'smtp.gmail.com';

/**
 *  Set the email address that you use to log-in 
 *  to your email account.
 *  Note: The email address has to belong to the above MAIL_HOST.
 */
const MAIL_USERNAME = getenv('MAIL_USERNAME');

/**
 *  Set the password you use to log-in to the above email account.
 *  Important!! If you use Gmail as your MAIL_HOST you have 
 *  to turn on 2 factor authentication and create an App password 
 *  and use it here instead of your password. 
 */
const MAIL_PASSWORD = getenv('MAIL_PASSWORD');
// Define the email address from which the email is sent.
const SEND_FROM = getenv('SEND_FROM');
// Define the name of the website from which the email is sent.
const SEND_FROM_NAME = 'Biblioteca "Mica Bufnita a Atenei"';
// Define the reply-to address.
const REPLY_TO = getenv('REPLY_TO');
// Define the reply-to name.
const REPLY_TO_NAME = 'Biblioteca "Mica Bufnita a Atenei"';


// Global variables ----------------------------------------

/**  
 *  We define the website's name in a constant so we can use 
 *  it anywhere in the application.
 *  Change the value to your website's name. 
 */
const WEBSITE_NAME = 'Biblioteca "Mica Bufnita a Atenei"';

/**	
 *  We define the website's URL so we can use it anywhere 
 *  in the application.
 */
// const WEBSITE_URL = 'http://localhost/daw_project'; mba.up.railway.app
const WEBSITE_URL = 'mba.up.railway.app';
