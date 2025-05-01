<?php

namespace Vluzrmos\BackendBr\Desafios\Http;

class JsonResponse extends Response
{
    public function __construct(
        protected mixed $body = null,
        protected int $status = 200,
        protected array $headers = [],
    ) {
        $headers[Headers::CONTENT_TYPE->value] ??= 'application/json; charset=utf-8';
        
        parent::__construct(
            body: json_encode($body),
            status: $status,
            headers: $headers
        );
    }

    public function body(mixed $body): static
    {
        $this->body = json_encode($body);

        return $this;
    }
}
