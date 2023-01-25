<?php

use JetBrains\PhpStorm\NoReturn;

/**
 * @param $inputName
 * @return mixed|null
 */
function input($inputName)
{
    return trim($_POST[$inputName] ?? null);
}

/**
 * @param array $payload
 * @param int $statusCode
 * @return never
 */
function json(array $payload, int $statusCode = 200): never
{
    header(http_response_code($statusCode));

    echo json_encode($payload);
    exit();
}

function authorize($callback)
{
    if(!$callback()) {
        header(http_response_code(403));
        echo json_encode(['error' => 'Unauthorized']);
        exit();
    }

    return;
}

function http_param(string $name): string
{
    return trim($_GET[$name] ?? null);
}

function dump()
{
    var_dump(func_get_args());
    die();
}