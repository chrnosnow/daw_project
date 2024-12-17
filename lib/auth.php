<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/mail_config.php';
require_once __DIR__ . '/mail.php';

const EXPIRY_TIME = 20 * 60; // in secunde


/**
 * Register a user
 * 
 * @param string $email
 * @param string $username
 * @param string $password
 * @param bool $gdpr
 * @param string $activation_code
 * @param int $expiry
 * @param bool $is_admin
 * @return bool
 * 
 * $gdpr - true if checkbox was marked for Politica de confidentialitate
 * $expiry - period of time (in seonds) that the activation code is available
 */
function register_user(string $email, string $username, string $password, bool $gdpr, string $activation_code, int $expiry = EXPIRY_TIME, bool $is_admin = false): bool
{
  if (empty($username) || empty($email) || empty($password) || !$gdpr) {
    return false;
  }

  $pass = password_hash($password, PASSWORD_BCRYPT);
  $card_no = generate_card_number();
  $act_code = password_hash($activation_code, PASSWORD_DEFAULT);
  $current_time = new DateTime('now', new DateTimeZone('Europe/Bucharest'));
  $act_expiry = $current_time->add(new DateInterval('PT20M'));
  $act_expiry = $act_expiry->format('Y-m-d H:i:s');
  $params = [$username, $email, $pass, $gdpr, $card_no, $is_admin, $act_code, $act_expiry];
  $query = 'INSERT INTO users(username, email, password, gdpr, card_no, is_admin, activation_code, activation_expiry) VALUES(?, ?, ?, ?, ?, ?, ?, ?)';

  return execute_query($query, "sssisiss", $params);
}


function generate_card_number()
{
  $card_number = 'MBA-' . strtoupper(randomNumber(6));
  $query = 'SELECT card_no FROM users WHERE card_no = UPPER(?)';
  $param = [$card_number];
  $card_no_from_db = execute_query_and_fetch($query, "s", $param);

  if (!empty($card_no_from_db)) {
    generate_card_number();
  }

  return $card_number;
}


/**
 * Find a user by username in the database
 * 
 * @param string $username
 * @return array|bool|null
 * If a username exists in the users table, the find_user_by_username() function returns an associative array with all the elements from the select statement. Otherwise, it returns false.
 */
function find_user_by_uname(string $username)
{
  $query = 'SELECT * FROM users WHERE username = ?';
  $param = [$username];
  return execute_query_and_fetch($query, "s", $param);
}


function is_user_active($user)
{
  return (int) $user[0]['active'] === 1;
}


function login_user(string $username, string $password)
{
  $user = find_user_by_uname($username);
  if ($user && is_user_active($user) && password_verify($password, $user[0]['password'])) {
    //prevent session fixation attack
    session_regenerate_id();
    //set user details in the session
    $_SESSION['user'] = [
      'id' => $user[0]['id'],
      'username' => $user[0]['username'],
      'email' => $user[0]['email'],
      'card_no' => $user[0]['card_no']
    ];
    return true;
  }
  return false;
}


function generate_activation_code()
{
  return randomNumber(16);
}


function send_activation_email(string $email, string $name = '', string $activation_code, string $alt_message = '')
{
  $activation_link = WEBSITE_URL . '/pagini/activate.php?email=' . $email . '&activation_code=' . $activation_code;
  $subject = 'Activare cont';
  $message = "
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
                    <p>Bun gasit!</p><br />
                    <p>
                      Multumim pentru inregistrarea pe site-ul Bibliotecii \"Mica
                      Bufnita a Atenei\".
                    </p>
                    <p>
                      Te rugam sa iti activezi contul accesand linkul de mai
                      jos, care este valabil " . EXPIRY_TIME / 60 . " de minute:</p>
                    <p><a href=$activation_link> $activation_link</a></p>
                    <br />
                    <p> Spor la citit,</p>
                    <p line-height='1.3'> Echipa MBA</p>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
    ";
  $alt_message = "Bun gasit!\n Multumim pentru inregistrarea pe site-ul Bibliotecii \"Mica
                      Bufnita a Atenei\".\n Te rugam sa iti activezi contul accesand linkul de mai jos, care este valabil " . EXPIRY_TIME / 60 . " de minute: $activation_link .\n Spor la citit,\n Echipa MBA";
  send_mail($email, $name, $subject, $message, $alt_message);
}


function find_unactivated_user(string $activation_code, string $email)
{
  $query = 'SELECT id, activation_code, activation_expiry < now() AS expired FROM users WHERE active = 0 AND email=?';
  $param = [$email];
  $user = execute_query_and_fetch($query, "s", $param);
  var_dump($user);
  if ($user) {
    // already expired, delete the inactive user with expired activation code
    if ((int)$user[0]["expired"] === 1) {

      delete_user_by_id($user[0]["id"]);
      return null;
    }
    //verify the password
    if (password_verify($activation_code, $user[0]['activation_code'])) {
      return $user;
    }
  }
  return null;
}


function delete_user_by_id(int $id, int $active = 0)
{
  $query = 'DELETE FROM users WHERE id = ? AND active = ?';
  $params = [$id, $active];
  return execute_query($query, "ii", $params);
}


function activate_user(int $user_id)
{
  $query = 'UPDATE users SET active = 1, activated_at = CURRENT_TIMESTAMP WHERE id = ?';
  $param = [$user_id];
  return execute_query($query, "i", $param);
}


function is_user_logged_in()
{
  return isset($_SESSION['user']);
}

function logout()
{
  if (is_user_logged_in()) {
    unset($_SESSION['user']);
    session_destroy();
    redirect_to('../index.php');
  }
}
