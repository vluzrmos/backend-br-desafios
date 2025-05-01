<?php

function dd(...$values): void
{
    foreach ($values as  $value) echo json_encode($value, JSON_PRETTY_PRINT) . PHP_EOL;

    exit;
}
