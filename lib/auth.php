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
function register_user(string $email, string $username, string $password, bool $is_admin = false): bool
{
    $pass = password_hash($password, PASSWORD_BCRYPT);
    $query = 'INSERT INTO accounts(username, password, email, is_admin)
            VALUES(?, ?, ?, ?)';

    $statement = db()->prepare($query);

    $statement->bind_param("sssi", $username, $pass, $email, $is_admin);

    echo $statement->affected_rows . ' user inserted into database.';
    return $statement->execute();
}
