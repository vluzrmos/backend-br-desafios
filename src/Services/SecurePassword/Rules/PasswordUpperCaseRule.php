<?php

namespace Vluzrmos\BackendBr\Desafios\Services\SecurePassword\Rules;


class PasswordUpperCaseRule extends AbstractPasswordRule
{
    public function  __construct(protected int $minUpperCase = 1)
    {
        //
    }

    public function validate(string $password): bool
    {
        return strlen(preg_replace('/[^A-Z]/', '', $password)) >= $this->minUpperCase;
    }

    public function message(): string
    {
        return sprintf("Verificar se a senha contém pelo menos %s letra maiúscula.", $this->minUpperCase === 1 ? 'uma' : sprintf("%02d", $this->minUpperCase));
    }
}
