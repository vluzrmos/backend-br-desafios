<?php

namespace Vluzrmos\BackendBr\Desafios\Database;

class MongoDbFactory
{
    protected $connection;

    public function getCollectionSchemas()
    {
        return [];
    }

    protected function getConnectionName(): string
    {
        return $this->connection;
    }

    public function connection(): MongoDb
    {
        /** @var MongoDb $mongo */
        $mongo = DatabaseManager::instance()
            ->connection($this->connection);

        $db = $mongo->getDatabase();

        foreach ($this->getCollectionSchemas() as $schema) {
            $query = iterator_to_array($db->listCollectionNames(
                ['filter' => ['name' => $schema->getName()]]
            ));

            if (count($query) > 0) {
                $db->getCollection($schema->getName())
                    ->createIndexes($schema->getIndexes());
                continue;
            }

            $db->createCollection($schema->getName(), [
                'validator' => $schema->getValidator(),
            ]);

            $db->getCollection($schema->getName())
                ->createIndexes($schema->getIndexes());
        }

        return $mongo;
    }
}
