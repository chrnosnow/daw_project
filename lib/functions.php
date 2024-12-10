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
