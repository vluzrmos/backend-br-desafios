<?php
namespace Vluzrmos\BackendBr\Desafios\Loans\Http\Controllers;

use Vluzrmos\BackendBr\Desafios\Loans\Models\Customers\Customer;
use Vluzrmos\BackendBr\Desafios\Loans\Models\Loans\InterestRate;

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

        $response = [
            'status' => 200,
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'json' => InterestRate::getCustomerInterests($customer),
        ];

        return $response;
    }
}