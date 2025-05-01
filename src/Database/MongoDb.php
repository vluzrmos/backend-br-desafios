<?php

namespace Vluzrmos\BackendBr\Desafios\Database;

use MongoDB\Client;

class MongoDb
{
    protected ?Client $client = null;

    public function __construct(
        public readonly string $host,
        public readonly int $port,
        public readonly string $database,
        public readonly string $username,
        public readonly string $password,
        public readonly string $authSource = 'admin',
        public readonly string $authMechanism = 'SCRAM-SHA-256',
    ) {
        //
    }

    /**
     * @param boolean $force
     * @return Client
     */
    public function connect($force = false)
    {
        if ($this->client && !$force) {
            return $this->client;
        }

        $this->client = $this->createClient();

        return $this->client;
    }

    public function uri()
    {
        $uri = "mongodb://{$this->username}:{$this->password}@{$this->host}:{$this->port}/{$this->database}";

        $query = [];

        if ($this->authSource) {
            $query['authSource'] = $this->authSource;
        }

        if ($this->authMechanism) {
            $query['authMechanism'] = $this->authMechanism;
        }

        if ($query) {
            $uri .= '?' . http_build_query($query);
        }

        return $uri;
    }
    /**
     * @return Client
     */
    public function createClient()
    {
        return new \MongoDB\Client($this->uri());
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    public function getDatabase(array $options = [])
    {
        return $this->connect()->getDatabase($this->database, $options);
    }

    public function __call(string $name, array $arguments)
    {
        $client = $this->getClient();

        if (!$client) {
            $client = $this->connect();
        }

        return $this->client->{$name}(...$arguments);
    }
}
