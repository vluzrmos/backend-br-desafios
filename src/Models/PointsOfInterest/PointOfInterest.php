<?php

namespace Vluzrmos\BackendBr\Desafios\Models\PointsOfInterest;

use MongoDB\Client;
use MongoDB\Database;

class PointOfInterest
{
    protected $collection = 'points-of-interest';

    public function __construct(
        public readonly string $name,
        public readonly float $x,
        public readonly float $y,
    ) {
        //
    }

    public function save(Database $database)
    {
        return $database
            ->getCollection($this->collection)
            ->insertOne([
                'name' => $this->name,
                'x' => $this->x,
                'y' => $this->y,
            ]);
    }
}
