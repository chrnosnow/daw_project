<?php

function sanitize_text(string $text)
{
    return htmlspecialchars(trim($text));
}

function validate_email(string $email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

// function is_unique(string $elem, array $existing_elems)
// {
//     return !in_array($elem, $existing_elems, true);
// }

function is_required(string $data)
{
    return isset($data) && trim($data) !== '';
}

function validate_integer(string $number)
{
    return filter_var($number, FILTER_VALIDATE_INT) !== false;
}

function validate_url(string $url)
{
    return filter_var($url, FILTER_VALIDATE_URL) !== false;
}

function sanitize_query(string $query)
{
    return preg_replace('/[^a-zA-Z0-9\s]/', '', trim($query));
}

function validate_password(string $password)
{
    //     DeMorgan's theorem, and write a regex that matches invalid passwords:
    // Anything with less than eight characters OR anything with no numbers OR anything with no uppercase OR or anything with no lowercase OR anything with no special characters.
    $pattern = '/^(.{0,7}|[^0-9]*|[^A-Z]*|[^a-z]*|[a-zA-Z0-9]*)$/';
    return preg_match($pattern, $password) === 0;
}

function is_unique(string $param, string $table, string $column)
{

    $sql = "SELECT $column FROM $table WHERE $column = ?";

    $stmt = db()->prepare($sql);
    $stmt->bind_param("s", $param);

    $stmt->execute();
    $stmt->store_result();

    return $stmt->affected_rows === 0;
}

function validate_isbn_format(string $isbn)
{
    // regex for ISBN-10 and ISBN-13
    // $pattern = "/^[0-9]+[- ]?[0-9]+[- ]?[0-9]+[- ]?[0-9]*[- ]*[xX0-9]$/";
    $pattern = "/[0-9]{9}[xX0-9]([0-9]{3})?$/";
    $only_numbers = str_replace('-', '', $isbn);

    return preg_match($pattern, $only_numbers) === 1;
}
