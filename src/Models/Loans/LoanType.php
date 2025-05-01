<?php

namespace Vluzrmos\BackendBr\Desafios\Models\Loans;

enum LoanType: string {
    case PERSONAL="PERSONAL";
    case GUARANTEED="GUARANTEED";
    case CONSIGNMENT="CONSIGNMENT";

    public function interestRate()
    {
        return match ($this) {
            self::PERSONAL => new InterestRate(0.04),
            self::GUARANTEED => new InterestRate(0.03),
            self::CONSIGNMENT => new InterestRate(0.02),
        };
    }
}
