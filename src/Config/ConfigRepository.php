<?php

namespace Vluzrmos\BackendBr\Desafios\Config;

class ConfigRepository
{
    protected static ?ConfigRepository $instance = null;

    protected array $config = [];

    protected function __construct()
    {
        //
    }
    
    public static function instance()
    {
        if (isset(static::$instance)) {
            return static::$instance;
        }

        return static::$instance = new static();
    }

    public function get(string $key, mixed $default = null): mixed
    {
        $segments = explode('.', $key, 2);

        if (empty($segments)) {
            return value($default);
        }

        if (!isset($this->config[$segments[0]])) {
            $file = __DIR__ . "/../../config/{$segments[0]}.php";

            if (!file_exists($file)) {
                return value($default);
            }

            $this->config[$segments[0]] = require $file;            
        }

        return array_get($this->config[$segments[0]], $segments[1] ?? null, $default);
    }
}
