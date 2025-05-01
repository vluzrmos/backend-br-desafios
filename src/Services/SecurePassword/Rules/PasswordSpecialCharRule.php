<?php

namespace Vluzrmos\BackendBr\Desafios\Services\SecurePassword\Rules;


class PasswordSpecialCharRule extends AbstractPasswordRule
{
    public function  __construct(protected int $minSpecialChar = 1)
    {
        //
    }

    public function validate(string $password): bool
    {
        return strlen(preg_replace('/[a-zA-Z0-9]/', '', $password)) >= $this->minSpecialChar;
    }

    public function message(): string
    {
        return sprintf("Verificar se a senha contém pelo menos %s caractere especial (e.g, !@#$%%).", $this->minSpecialChar === 1 ? 'um' : sprintf("%02d", $this->minSpecialChar));
    }
}
