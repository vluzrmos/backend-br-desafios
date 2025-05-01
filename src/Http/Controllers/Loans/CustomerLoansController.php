<?php
namespace Vluzrmos\BackendBr\Desafios\Http\Controllers\Loans;

use Vluzrmos\BackendBr\Desafios\Http\JsonResponse;
use Vluzrmos\BackendBr\Desafios\Models\Loans\Customer;
use Vluzrmos\BackendBr\Desafios\Models\Loans\Loan;
use Vluzrmos\BackendBr\Desafios\Services\Loans\LoanService;

class CustomerLoansController
{
    public function __invoke()
    {
        $customer = new Customer(
            age: $_REQUEST['age'] ?? 0,
            cpf: $_REQUEST['cpf'] ?? '',
            name: $_REQUEST['name'] ?? '',
            income: $_REQUEST['income'] ?? 0.0,
            location: $_REQUEST['location'] ?? '',
        );

        $response = new JsonResponse(
            body: LoanService::getInstance()->getCustomerInterests($customer),
        );

        return $response;
    }
}