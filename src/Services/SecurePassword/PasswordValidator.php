<?php

namespace Vluzrmos\BackendBr\Desafios\Services\SecurePassword;

use Vluzrmos\BackendBr\Desafios\Services\SecurePassword\Rules\BailPasswordRule;
use Vluzrmos\BackendBr\Desafios\Services\SecurePassword\Rules\IBailPasswordRule;
use Vluzrmos\BackendBr\Desafios\Services\SecurePassword\Rules\IPasswordRule;
use Vluzrmos\BackendBr\Desafios\Services\SecurePassword\Rules\PasswordLowerCaseRule;
use Vluzrmos\BackendBr\Desafios\Services\SecurePassword\Rules\PasswordMinLengthRule;
use Vluzrmos\BackendBr\Desafios\Services\SecurePassword\Rules\PasswordNumberRule;
use Vluzrmos\BackendBr\Desafios\Services\SecurePassword\Rules\PasswordRequiredRule;
use Vluzrmos\BackendBr\Desafios\Services\SecurePassword\Rules\PasswordSpecialCharRule;
use Vluzrmos\BackendBr\Desafios\Services\SecurePassword\Rules\PasswordUpperCaseRule;

/**
 * @method self required()
 * @method self number(int $minNumber = 1)
 * @method self upper(int $minUpper = 1)
 * @method self lower(int $minLower = 1)
 * @method self special(int $minSpecial = 1)
 * @method self min(int $minLength = 8)
 */
class PasswordValidator
{
    protected array $rules = [];

    protected array $messages = [];

    protected bool $bail = false;

    protected array $ruleBuilderMethods = [
        'required' => PasswordRequiredRule::class,
        'number' => PasswordNumberRule::class,
        'upper' => PasswordUpperCaseRule::class,
        'lower' => PasswordLowerCaseRule::class,
        'special' => PasswordSpecialCharRule::class,
        'min' => PasswordMinLengthRule::class,
    ];

    public function add(IPasswordRule $rule)
    {
        $this->rules[] = $rule;

        return $this;
    }

    public function bail($bail = true)
    {
        $this->bail = $bail;

        return $this;
    }

    public function validate(string $password): bool
    {
        $this->messages = [];
        $valid = true;
        foreach ($this->rules as $rule) {
            if ($this->bail && !$valid) {
                return false;
            }

            if (!$rule->validate($password)) {
                $this->messages[] = $rule->message();
                $valid = false;
            }

            if ($rule instanceof IBailPasswordRule && !$valid) {
                return false;
            }
        }

        return $valid;
    }

    public function messages(): array
    {
        return $this->messages;
    }

    public function __call(string $name, array $arguments)
    {
        if (array_key_exists($name, $this->ruleBuilderMethods)) {
            $class = $this->ruleBuilderMethods[$name];
            return $this->add(new $class(...$arguments));
        }

        throw new \BadMethodCallException("Método {$name} não existe.");
    }
}
