<?php

namespace Vluzrmos\BackendBr\Desafios\Services\SecurePassword\Rules;

interface IPasswordRule
{
    public function validate(string $password): bool;

    public function message(): string;
}
