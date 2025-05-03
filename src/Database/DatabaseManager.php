<?php

namespace Vluzrmos\BackendBr\Desafios\Database;

use Vluzrmos\BackendBr\Desafios\Config\ConfigRepository;

class DatabaseManager
{
    protected static ?DatabaseManager $instance = null;

    protected array $connections = [];

    public static function instance(): static
    {
        if (static::$instance) {
            return static::$instance;
        }

        return static::$instance = new static();
    }

    public function getMongoDbDriver(array $config): MongoDb
    {
        return new MongoDb(
            host: $config['host'] ?? 'localhost',
            port: $config['port'] ?? 27017,
            database: $config['database'] ?? null,
            username: $config['username'] ?? null,
            password: $config['password'] ?? null,
            authSource: $config['authSource'] ?? 'admin',
            authMechanism: $config['authMechanism'] ?? 'SCRAM-SHA-256',
        );
    }

    public function connection($name)
    {
        if (isset($this->connections[$name])) {
            return $this->connections[$name];
        }

        $config = ConfigRepository::instance()->get('database.connections.' . $name);

        $driverName = $config['driver'] ?? 'mongodb';

        $method = 'get' . $driverName . 'Driver';

        if (!method_exists($this, $method)) {
            throw new \Exception("Driver {$driverName} not found");
        }

        $this->connections[$name] = $this->{$method}($config);

        return $this->connections[$name];
    }
}
