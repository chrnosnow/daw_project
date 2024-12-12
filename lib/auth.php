<?php
require_once __DIR__ . '/../config/database.php';

/**
 * Register a user
 *
 * @param string $email
 * @param string $username
 * @param string $password
 * @param bool $is_admin
 * @return bool
 */
function register_user(string $email, string $username, string $password, bool $gdpr, bool $is_admin = false): bool
{
    if (empty($username) || empty($email) || empty($password) || !$gdpr) {
        return false;
    }

    $pass = password_hash($password, PASSWORD_BCRYPT);
    $query = 'INSERT INTO accounts(username, password, email, gdpr, is_admin)
            VALUES(?, ?, ?, ?, ?)';

    $statement = db()->prepare($query);

    $statement->bind_param("sssii", $username, $pass, $email, $gdpr, $is_admin);

    return $statement->execute();
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

    $query = 'SELECT * FROM accounts WHERE username = ?';
    $statement = db()->prepare($query);
    $statement->bind_param("s", $username);
    $statement->execute();
    $result = $statement->get_result();
    return $result->fetch_assoc();
}
function login_user(string $username, string $password)
{
    $user = find_user_by_uname($username);
    if ($user && password_verify($password, $user['password'])) {
        //prevent session fixation attack
        session_regenerate_id();
        //set user details in the session
        $_SESSION['user'] = [
            'id' => $user['id'],
            'username' => $user['username'],
            'email' => $user['email']
        ];
        return true;
    }
    return false;
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
