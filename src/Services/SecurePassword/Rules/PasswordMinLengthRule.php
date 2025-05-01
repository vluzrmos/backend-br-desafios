<?php

namespace Vluzrmos\BackendBr\Desafios\Services\SecurePassword\Rules;


class PasswordMinLengthRule extends AbstractPasswordRule
{
    public function __construct(protected int $minLength)
    {
        // 
    }

    public function validate(string $password): bool
    {
        return strlen($password) >= $this->minLength;
    }

    public function message(): string
    {
        return sprintf("Verificar se a senha possui pelo menos %02d caracteres.", $this->minLength);
    }
}
