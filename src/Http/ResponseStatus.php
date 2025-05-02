<?php

namespace Vluzrmos\BackendBr\Desafios\Http;

enum ResponseStatus: int
{
    case OK = 200;
    case CREATED = 201;
    case NO_CONTENT = 204;
    case BAD_REQUEST = 400;
    case UNAUTHORIZED = 401;
    case FORBIDDEN = 403;
    case NOT_FOUND = 404;
    case INTERNAL_SERVER_ERROR = 500;
    case SERVICE_UNAVAILABLE = 503;
    case UNPROCESSABLE_ENTITY = 422;

    public function reasonPhrase(): string
    {
        return match ($this) {
            self::OK => 'OK',
            self::CREATED => 'Created',
            self::NO_CONTENT => 'No Content',
            self::BAD_REQUEST => 'Bad Request',
            self::UNAUTHORIZED => 'Unauthorized',
            self::FORBIDDEN => 'Forbidden',
            self::NOT_FOUND => 'Not Found',
            self::INTERNAL_SERVER_ERROR => 'Internal Server Error',
            self::SERVICE_UNAVAILABLE => 'Service Unavailable',
            self::UNPROCESSABLE_ENTITY => 'Unprocessable Entity',
        };
    }

    public static function firstWhereStatusCode(int $status): ?self
    {
        foreach (self::cases() as $case) {
            if ($case->value === $status) {
                return $case;
            }
        }

        return null;
    }

    public static function statusReasonPhrase(int $status): string
    {
        return self::firstWhereStatusCode($status)?->reasonPhrase() ?? 'Unknown Status Code';
    }

}
