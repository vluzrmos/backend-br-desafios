<?php

namespace Vluzrmos\BackendBr\Desafios\Services\SecurePassword\Rules;

class BailPasswordRule extends AbstractPasswordRule implements IBailPasswordRule {
    public function __construct(protected IPasswordRule $rule) {
      //
    }
  
    public function validate(string $password): bool {
      return $this->rule->validate($password);
    }
  
    public function message(): string {
      return $this->rule->message();
    }
  
    public function toBail(): self {
      return $this;
    }
  }
