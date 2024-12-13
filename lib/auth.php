<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/mail_config.php';
require_once __DIR__ . '/mail.php';

const EXPIRY_TIME = 20 * 60;
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
    $act_expiry = date('Y-m-d H:i:s',  time() + $expiry);

    $query = 'INSERT INTO users(username, email, password, gdpr, card_no, is_admin, activation_code, activation_expiry)
    VALUES(?, ?, ?, ?, ?, ?, ?, ?)';

    $statement = db()->prepare($query);

    $statement->bind_param("sssisiss", $username, $email, $pass, $gdpr, $card_no, $is_admin, $act_code, $act_expiry);

    return $statement->execute();
}

function generate_card_number()
{

    return 'MBA-' . strtoupper(randomNumber(3));
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
    $statement = db()->prepare($query);
    $statement->bind_param("s", $username);
    $statement->execute();
    $result = $statement->get_result();
    return $result->fetch_assoc();
}

function is_user_active($user)
{
    return (int) $user['active'] === 1;
}

function login_user(string $username, string $password)
{
    $user = find_user_by_uname($username);
    if ($user && is_user_active($user) && password_verify($password, $user['password'])) {
        //prevent session fixation attack
        session_regenerate_id();
        //set user details in the session
        $_SESSION['user'] = [
            'id' => $user['id'],
            'username' => $user['username'],
            'email' => $user['email'],
            'card_no' => $user['card_no']
        ];
        return true;
    }
    return false;
}

function generate_activation_code()
{
    return randomNumber(32);
}

function send_activation_email(string $email, string $name = '', string $activation_code)
{
    $activation_link = WEBSITE_URL . '/activate.php?email=' . $email . '&activation_code=' . $activation_code;
    $subject = 'Activare cont';
    $message = '
    <div>
            <table
              width="680"
              border="0"
              align="center"
              style="font-family: \'Lato\', sans-serif"
            >
              <tbody>
                <tr>
                  <td align="center" valign="center">
                    <img
                      alt="Biblioteca Mica bufnita a Atenei"
                      src="./resurse/imagini/logo_mba.avif"
                      style="width: 200px; height: auto"
                    />
                  </td>
                </tr>
                <tr>
                  <td style="font-size: 1.2em">
                    <p>Bun gasit!</p>
                    <br />
                    <p>
                      Multumim pentru inregistrarea pe site-ul Bibliotecii "Mica
                      Bufnita a Atenei".
                    </p>
                    <p>
                      Te rugam sa iti activezi contul accesand linkul de mai
                      jos, care este valabil' . EXPIRY_TIME . 'de minute:
                    </p>
                    <p><a href="' . $activation_link . '">' . $activation_link . '</a></p>
                    <br />
                    <p line-height="1.5">Spor la citit,</p>
                    <p line-height="1.5">Echipa MBA</p>
                    <p></p>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
    ';
    send_mail($email, $name, $subject, $message);
}

function find_unactivated_user(string $activation_code, string $email)
{
    $query = 'SELECT id, activation_code, activation_expiry < now() AS expired FROM users WHERE active = 0 AND email=?';
    $stmt = db()->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $res = $stmt->get_result();
    $user = $res->fetch_assoc();

    if ($user) {
        // already expired, delete the in active user with expired activation code
        if ((int)$user['expired'] === 1) {

            delete_user_by_id($user['id']);
            return null;
        }
        //verify the password
        if (password_verify($activation_code, $user['activation_code'])) {
            return $user;
        }
    }
    return null;
}

function delete_user_by_id(int $id, int $active = 0)
{
    $query = 'DELETE FROM users WHERE id = ? AND active = ?';
    $stmt = db()->prepare($query);
    $stmt->bind_param('ii', $id, $active);
    return $stmt->execute();
}

function activate_user(int $user_id)
{
    $query = 'UPDATE users SET active = 1, activate_at = CURRENT_TIMESTAMP WHERE id = ?';
    $stmt = db()->prepare($query);
    $stmt->bind_param('i', $user_id);
    return $stmt->execute();
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
