<?php

namespace Vluzrmos\BackendBr\Desafios\Database;

class PointsOfInterestMongoDbFactory
{
    public function __construct(
        protected ?string $host = null,
        protected ?int $port = null,
        protected ?string $database = null,
        protected ?string $username = null,
        protected ?string $password = null,
        protected string $authSource = 'admin',
        protected string $authMechanism = 'SCRAM-SHA-256',
    ) {
        $this->database = $database ?: env('MONGO_DB_POINTS_OF_INTEREST', 'points-of-interest');
        $this->host = $host ?: env('MONGO_HOST', 'localhost');
        $this->port = $port ?: env('MONGO_PORT', 27017);
        $this->username = $username ?: env('MONGO_USERNAME', 'desafios');
        $this->password = $password ?: env('MONGO_PASSWORD', 'desafios');
        $this->authSource = $authSource ?: env('MONGO_AUTH_SOURCE', 'admin');
        $this->authMechanism = $authMechanism ?: env('MONGO_AUTH_MECHANISM', 'SCRAM-SHA-256');
    }

    public function createMongoDb(): MongoDb
    {
        return new MongoDb(
            host: $this->host,
            port: $this->port,
            database: $this->database,
            username: $this->username,
            password: $this->password,
            authSource: $this->authSource,
            authMechanism: $this->authMechanism,
        );
    }
}
