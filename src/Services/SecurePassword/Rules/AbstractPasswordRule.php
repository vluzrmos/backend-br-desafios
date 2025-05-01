<?php

namespace Vluzrmos\BackendBr\Desafios\Services\SecurePassword\Rules;

abstract class AbstractPasswordRule implements IPasswordRule
{
    public function toBail(): IBailPasswordRule
    {
        return new BailPasswordRule($this);
    }
}
