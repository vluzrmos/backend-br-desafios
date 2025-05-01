<?php

namespace Vluzrmos\BackendBr\Desafios\Loans\Models\Loans;

enum LoanType: string {
    case PERSONAL="PERSONAL";
    case GUARANTEED="GUARANTEED";
    case CONSIGNMENT="CONSIGNMENT";
}
