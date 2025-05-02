<?php

namespace Vluzrmos\BackendBr\Desafios\Models\PointsOfInterest;

use JsonSerializable;
use MongoDB\Client;
use MongoDB\Database;

class PointOfInterest implements JsonSerializable
{
    public function __construct(
        public readonly string $name,
        public readonly float $x,
        public readonly float $y,
    ) {
        //
    }

    public function save(Database $database)
    {
        $schema = PointOfInterestCollectionSchema::instance();
        $collection = $database->getCollection($schema->getName());

        return $collection->insertOne([
                'name' => $this->name,
                'point' => [
                    "type" => "Point",
                    "coordinates" => [
                        $this->x,
                        $this->y,
                    ],
                ]
            ]);
    }

    public function jsonSerialize(): array
    {
        return [
            'name' => $this->name,
            'x' => $this->x,
            'y' => $this->y,
        ];
    }

    public function __toString(): string
    {
        return json_encode($this->jsonSerialize());
    }
}
