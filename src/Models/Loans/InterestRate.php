<?php

namespace Vluzrmos\BackendBr\Desafios\Loans\Models\Loans;

use JsonSerializable;

class InterestRate implements JsonSerializable
{
    public function __construct(protected float $value)
    {
        //
    }

    public function value()
    {
        return $this->value;
    }

    public function toInt($decimals = 2)
    {
        return (int) ($this->value * pow(10, $decimals));
    }

    public function jsonSerialize(): mixed
    {
        return $this->value;
    }
}
