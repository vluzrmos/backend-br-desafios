<?php

use Vluzrmos\BackendBr\Desafios\Http\Controllers\Loans\CustomerLoansController;
use Vluzrmos\BackendBr\Desafios\Http\Controllers\PointsOfInterest\PointOfInterestIndexController;
use Vluzrmos\BackendBr\Desafios\Http\Controllers\PointsOfInterest\PointOfInterestStoreController;
use Vluzrmos\BackendBr\Desafios\Http\Controllers\PointsOfInterest\PointOfInterestNearController;
use Vluzrmos\BackendBr\Desafios\Http\Controllers\SecurePassword\ValidatePasswordController;

return [
    'POST /loans/customer-loans' => CustomerLoansController::class,
    'POST /secure-password/validate-password' => ValidatePasswordController::class,
    'POST /points-of-interest' => PointOfInterestStoreController::class,
    'GET /points-of-interest' => PointOfInterestIndexController::class,
    'GET /points-of-interest/near' => PointOfInterestNearController::class,
];