<?php

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