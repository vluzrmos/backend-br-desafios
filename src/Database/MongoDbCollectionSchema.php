<?php

namespace Vluzrmos\BackendBr\Desafios\Database;

class MongoDbCollectionSchema
{
    protected static $instances = [];

    protected string $name;
    protected array $indexes = [];
    protected array $validator = [];

    public static function instance(): static
    {
        if (isset(static::$instances[static::class])) {
            return static::$instances[static::class];
        }

        static::$instances[static::class] = new static();

        return static::$instances[static::class];
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getValidator(): array
    {
        return $this->validator;
    }

    public function getIndexes(): array
    {
        return $this->indexes;
    }
}
