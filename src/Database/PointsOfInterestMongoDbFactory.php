<?php

namespace Vluzrmos\BackendBr\Desafios\Database;

use Vluzrmos\BackendBr\Desafios\Models\PointsOfInterest\PointOfInterestCollectionSchema;

class PointsOfInterestMongoDbFactory extends MongoDbFactory
{
    protected $connection = 'points-of-interest';

    public function getCollectionSchemas()
    {
        return [
            PointOfInterestCollectionSchema::instance(),
        ];
    }
}
