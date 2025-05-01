<?php

namespace Vluzrmos\BackendBr\Desafios\Models\Loans;

use Closure;

class Loan
{
    protected static $instances = [];
    protected static $loaded = false;

    public function __construct(
        public readonly int $id,
        public readonly string $description,
        public readonly LoanType $loanType,
        public readonly Closure $condition,
    ) {}
}
