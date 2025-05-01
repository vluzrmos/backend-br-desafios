<?php

namespace Vluzrmos\BackendBr\Desafios\Services\SecurePassword\Rules;

class PasswordNumberRule extends AbstractPasswordRule {
    public function  __construct(protected int $minNumber=1) {
      
    }
  
    public function validate(string $password): bool {
      return strlen(preg_replace('/\D/', '',$password)) >= $this->minNumber;
    }
  
    public function message(): string {
      return sprintf("Verificar se a senha contém pelo menos %s dígito numérico.", $this->minNumber  === 1 ? 'um' : sprintf("%02d", $this->minNumber));
    }
  }