<?php
namespace Vluzrmos\BackendBr\Desafios\Services\Loans;

use Vluzrmos\BackendBr\Desafios\Models\Loans\Customer;
use Vluzrmos\BackendBr\Desafios\Models\Loans\Loan;
use Vluzrmos\BackendBr\Desafios\Models\Loans\LoanType;

class LoanService
{
    protected static self $singleton;
    protected $instances = [];
    protected $loaded = false;


    protected function __construct()
    {
        // Prevent instantiation
    }
    
    public static function getInstance()
    {
        static::$singleton = static::$singleton ?? new self();
        
        return static::$singleton;
    }

    protected function add(Loan $loan)
    {
        $this->instances[$loan->id] = $loan;
    }

    public function load()
    {
        if ($this->loaded) {
            return;
        }

        $this->loaded = true;

        static::add(new Loan(
            id: 1,
            description: 'Conceder o empréstimo pessoal se o salário do cliente for igual ou inferior a R$ 3000.',
            loanType: LoanType::PERSONAL,
            condition: function (Customer $customer) {
                return $customer->income <= 3000;
            }
        ));

        static::add(new Loan(
            id: 2,
            description: 'Conceder o empréstimo pessoal se o salário do cliente estiver entre R$ 3000 e R$ 5000, se o cliente tiver menos de 30 anos e residir em São Paulo (SP).',
            loanType: LoanType::PERSONAL,
            condition: function (Customer $customer) {
                return $customer->income > 3000
                    && $customer->income <= 5000
                    && $customer->age < 30
                    && $customer->location === 'SP';
            }
        ));

        static::add(new Loan(
            id: 3,
            description: 'Conceder o empréstimo consignado se o salário do cliente for igual ou superior a R$ 5000.',
            loanType: LoanType::CONSIGNMENT,
            condition: function (Customer $customer) {
                return $customer->income >= 5000;
            }
        ));

        static::add(new Loan(
            id: 4,
            description: 'Conceder o empréstimo com garantia se o salário do cliente for igual ou inferior a R$ 3000.',
            loanType: LoanType::GUARANTEED,
            condition: function (Customer $customer) {
                return $customer->income <= 3000;
            }
        ));

        // Conceder o empréstimo com garantia se o salário do cliente estiver entre R$ 3000 e R$ 5000, se o cliente tiver menos de 30 anos e residir em São Paulo (SP)
        static::add(new Loan(
            id: 5,
            description: 'Conceder o empréstimo com garantia se o salário do cliente estiver entre R$ 3000 e R$ 5000, se o cliente tiver menos de 30 anos e residir em São Paulo (SP).',
            loanType: LoanType::GUARANTEED,
            condition: function (Customer $customer) {
                return $customer->income > 3000
                    && $customer->income <= 5000
                    && $customer->age < 30
                    && trim(mb_strtoupper($customer->location)) === 'SP';
            }
        ));
    }

    public function getCustomerInterests(Customer $customer)
    {
        self::load();

        $loans = [];

        foreach ($this->instances as $loan) {
            if (!$loan->loanType) {
                continue;
            }

            $condition = $loan->condition;

            if ($condition($customer)) {
                $loans[] = [
                    'interest_rate' => $loan->loanType->interestRate()?->toInt() ?? 0,
                    'type' => $loan->loanType->value,
                ];
            }
        }

        return [
            'customer' => $customer->name,
            'loans' => $loans,
        ];
    }
}