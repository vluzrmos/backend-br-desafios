<?php
namespace Vluzrmos\BackendBr\Desafios\Loans\Models\Loans;

use Closure;
use Vluzrmos\BackendBr\Desafios\Loans\Models\Customers\Customer;

class InterestRate
{
    protected static $instances = [];
    protected static $loaded = false;

    public function __construct(
        protected int $id,
        protected string $description,
        protected LoanType $loanType,
        protected Closure $condition,
    ) {
    }

    protected static function add(self $interestRate)
    {
        self::$instances[$interestRate->id] = $interestRate;
    }

    public static function load()
    {
        if (self::$loaded) {
            return;
        }

        self::$loaded = true;

        static::add(new self(
            id: 0,
            description: 'Conceder o empréstimo pessoal se o salário do cliente for igual ou inferior a R$ 3000.',
            loanType: LoanType::PERSONAL,
            condition: function (Customer $customer) {
                return $customer->income <= 3000;
            }
        ));

        static::add(new self(
            id: 1,
            description: 'Conceder o empréstimo pessoal se o salário do cliente estiver entre R$ 3000 e R$ 5000, se o cliente tiver menos de 30 anos e residir em São Paulo (SP).',
            loanType: LoanType::PERSONAL,
            condition: function (Customer $customer) {
                return $customer->income > 3000
                    && $customer->income <= 5000
                    && $customer->age < 30
                    && $customer->location === 'SP';
            }
        ));

        static::add(new self(
            id: 2,
            description: 'Conceder o empréstimo consignado se o salário do cliente for igual ou superior a R$ 5000.',
            loanType: LoanType::CONSIGNMENT,
            condition: function (Customer $customer) {
                return $customer->income >= 5000;
            }
        ));

        static::add(new self(
            id: 3,
            description: 'Conceder o empréstimo com garantia se o salário do cliente for igual ou inferior a R$ 3000.',
            loanType: LoanType::GUARANTEED,
            condition: function (Customer $customer) {
                return $customer->income <= 3000;
            }
        ));

        // Conceder o empréstimo com garantia se o salário do cliente estiver entre R$ 3000 e R$ 5000, se o cliente tiver menos de 30 anos e residir em São Paulo (SP)
        static::add(new self(
            id: 4,
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

    public static function getCustomerInterests(Customer $customer)
    {
        self::load();

        $loans = [];

        for ($i = count(self::$instances) - 1; $i >= 0; $i--) {
            $interestRate = self::$instances[$i];
            $condition = $interestRate->condition;

            if ($condition($customer)) {
                $loans[] = [
                    'interest_rate' => $interestRate->id,
                    'type' => $interestRate->loanType->value,
                ];
            }
        }

        return [
            'customer' => $customer->name,
            'loans' => $loans,
        ];
    }
}