<?php

namespace Vluzrmos\BackendBr\Desafios\Http;

class RedirectResponse extends Response
{
    public function __construct(
        protected mixed $url = null,
        protected int $status = 200,
        protected array $headers = [],
    ) {
        $body = null;

        $headers[Headers::CONTENT_TYPE->value] ??= 'application/json; charset=utf-8';
        $headers[Headers::LOCATION->value] ??= $this->url;
        $headers[Headers::CACHE_CONTROL->value] ??= 'no-store, no-cache, must-revalidate, max-age=0';
        
        parent::__construct(
            body: $body,
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
