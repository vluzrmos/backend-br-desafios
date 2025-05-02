<?php

namespace Vluzrmos\BackendBr\Desafios\Http;

class Response
{
    public function __construct(
        protected mixed $body = null,
        protected int $status = 200,
        protected array $headers = [],
    ) {}

    public function status(int $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function headers(array $headers): static
    {
        foreach ($headers as $key => $value) {
            $this->headers[$key] = $value;
        }

        return $this;
    }

    public function body(mixed $body): static
    {
        $this->body = $body;

        return $this;
    }

    public function send()
    {
        $phrase = ResponseStatus::statusReasonPhrase($this->status);
        header("HTTP/1.1 {$this->status} $phrase");

        foreach ($this->headers as $key => $value) {
            header("$key: $value");
        }
        
        echo $this->body;
    }
}
