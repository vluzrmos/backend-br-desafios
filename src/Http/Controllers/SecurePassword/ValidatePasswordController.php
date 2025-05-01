<?php

namespace Vluzrmos\BackendBr\Desafios\Http\Controllers\SecurePassword;

use Vluzrmos\BackendBr\Desafios\Http\JsonResponse;
use Vluzrmos\BackendBr\Desafios\Http\Response;
use Vluzrmos\BackendBr\Desafios\Http\ResponseStatus;
use Vluzrmos\BackendBr\Desafios\Services\SecurePassword\PasswordValidator;

class ValidatePasswordController
{
    public function __invoke()
    {
        $validator = new PasswordValidator();
        $validator
            ->required()
            ->min(8)
            ->special(1)
            ->number(1)
            ->upper(1)
            ->lower(1);

        $password = $_REQUEST['password'] ?? '';

        if ($validator->validate($password)) {
            return new Response(
                status: ResponseStatus::NO_CONTENT->value,
            );
        }

        return new JsonResponse(
            status: ResponseStatus::BAD_REQUEST->value,
            body: [
                'errors' => ['password' => $validator->messages()],
            ]
        );
    }
}
