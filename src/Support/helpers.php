<?php

use Vluzrmos\BackendBr\Desafios\Config\ConfigRepository;

function value(mixed $value, mixed ...$args) {
    if (is_callable($value)) {
        return $value(...$args);
    }

    return $value;
}

function env(string $key, mixed $default = null): mixed
{
    if (!$key) {
        return value($default);
    }

    if (isset($_ENV[$key])) {
        return $_ENV[$key];
    }

    $value = getenv($key);

    if ($value === false) {
        return value($default);
    }
    
    return $value;
}

/**
 * @param array $array
 * @param string|array $key in dot notation or array of keys
 * @param mixed $default
 * @return mixed
 */
function array_get(array $array, string|array $key, mixed $default = null): mixed
{
    if (empty($key)) {
        return $array;
    }

    $keys = is_array($key) ? $key : explode('.', $key);

    foreach ($keys as $k) {
        if (!isset($array[$k])) {
            return value($default);
        }

        $array = $array[$k];
    }

    return $array;
}


function random_string(int $length = 16): string
{
    return bin2hex(random_bytes((int) floor($length / 2)));
}

function config(string $key, mixed $default = null): mixed
{
    return ConfigRepository::instance()->get($key, $default);
}