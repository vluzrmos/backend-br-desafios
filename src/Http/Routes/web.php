<?php

use Vluzrmos\BackendBr\Desafios\Http\Controllers\Loans\CustomerLoansController;
use Vluzrmos\BackendBr\Desafios\Http\Controllers\SecurePassword\ValidatePasswordController;

return [
    'POST /loans/customer-loans' => CustomerLoansController::class,
    'POST /secure-password/validate-password' => ValidatePasswordController::class,
];