<?php

namespace Vluzrmos\BackendBr\Desafios\Services\SecurePassword\Rules;


class PasswordLowerCaseRule extends AbstractPasswordRule
{
    public function  __construct(protected int $minLowerCase = 1)
    {
        //
    }

    public function validate(string $password): bool
    {
        return strlen(preg_replace('/[^a-z]/', '', $password)) >= $this->minLowerCase;
    }

    public function message(): string
    {
        return sprintf("Verificar se a senha contém pelo menos %s letra minúscula.", $this->minLowerCase === 1 ? 'uma' : sprintf("%02d", $this->minLowerCase));
    }
}
