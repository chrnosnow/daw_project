<?php

function view(string $filename, array $data = [])
{
    // create variables from the associative array
    foreach ($data as $key => $value) {
        $$key = $value;
    }
    require_once __DIR__ . '/../fragmente/' . $filename . '.php';
}

function is_post_req()
{
    return strtoupper($_SERVER['REQUEST_METHOD']) === 'POST';
}


function is_get_req()
{
    return strtoupper($_SERVER['REQUEST_METHOD']) === 'GET';
}


/**
 * Execute prepared SQL queries
 *
 * @param string $query - Interogarea SQL.
 * @param string $types - Tipurile de date pentru parametri (ex: "sdi" pentru string, double, int).
 * @param array $params - Valorile pentru parametri.
 * @return bool - Rezultatul metodei execute().
 */
function execute_query(string $query, string $types = '', array $params = [])
{
    $stmt = db()->prepare($query);

    if (!empty($types) && !empty($params)) {
        // Creează referinte pentru fiecare element din $params (bind_param are nevoie de referinte)
        $param_references = [];
        foreach ($params as $key => $value) {
            $param_references[$key] = &$params[$key];
        }

        $stmt->bind_param($types, ...$param_references);
        // $stmt->bind_param($types, $params);
    }

    return $stmt->execute();
}


/**
 * Returns a nested array having an enumerated index from a select query
 * 
 * @param string $query
 * @param string $types
 * @param array $params
 * @param int $arrayType - constant for fetch_all() method; e.g. MYSQLI_ASSOC for associative array, MYSQLI_NUM for array with enumerated index 
 * @return array
 */
function execute_query_and_fetch(string $query, string $types = '', array $params = [], int $fetchMode = MYSQLI_ASSOC)
{
    $stmt = db()->prepare($query);

    if (!empty($types) && !empty($params)) {
        // Creează referinte pentru fiecare element din $params (bind_param are nevoie de referinte)
        // $param_references = [];
        // foreach ($params as $key => $value) {
        //     $param_references[$key] = &$params[$key];
        // }

        // $stmt->bind_param($types, ...$param_references);
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    if ($result) {
        $data = $result->fetch_all($fetchMode);
    }

    return $data;
}


function display_alert(string $key)
{
    if (!isset($key) || !isset($_SESSION[$key])) {
        return;
    }

    $messages = $_SESSION[$key];
    unset($_SESSION[$key]);
    foreach ($messages as $msg_key => $msg_string) {
        echo '<div class="' . $key . '">' . '<p>' . $msg_string . '</p></div>';
    }
}

function redirect_to(string $url): void
{
    header('Location:' . $url);
    exit;
}

/**
 * Generate a random alphanumeric string
 * 
 * @param mixed $length (prefferably even number; odd number will floor to even number)
 * @return string
 */
function randomNumber($length)
{
    //half the length because each byte is 
    //represented by two hexadecimal characters
    $bytes = random_bytes($length / 2);
    //convert bytes to hexadecimal string
    $rnd = bin2hex($bytes);

    return $rnd;
}

/**
 * Generate a random quote from a nested array by randomizing the index.
 * The quote is fixed for a day.
 * 
 * @param array $quotes - nested array, e.g. $quotes[index]['quote'], $quotes[index]['author'], $quotes[index]['writing']
 * @return mixed - a nested array containing $quotes[randomized_index], i.e. the information regarding the quote of the day
 */
function generate_random_quote(array $quotes)
{
    //generating seed in order to have the same quote during a day, even if the page is reloaded
    $current_day = date('Ymd');
    mt_srand($current_day);

    //get random index based on the seed
    $index = mt_rand(0, count($quotes) - 1);

    return $quotes[$index];
}
