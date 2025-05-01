<?php
namespace Vluzrmos\BackendBr\Desafios\Loans\Models\Customers;

class Customer {
    /**
     * @param int $age
     * @param string $cpf
     * @param string $name
     * @param float $income
     * @param string $location
     *
     */
    public function __construct(
        public readonly int $age,
        public readonly string $cpf,
        public readonly string $name,
        public readonly float $income,
        public readonly string $location,
    ) {
    }
}