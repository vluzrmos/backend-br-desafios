<?php

namespace Vluzrmos\BackendBr\Desafios\Services\SecurePassword\Rules;

class PasswordRequiredRule extends AbstractPasswordRule
{
    public function validate(string $password): bool
    {
        return !empty($password);
    }

    public function message(): string
    {
        return "Verificar se a senha foi informada.";
    }
}
