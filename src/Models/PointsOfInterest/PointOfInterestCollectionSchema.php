<?php

namespace Vluzrmos\BackendBr\Desafios\Models\PointsOfInterest;

use Vluzrmos\BackendBr\Desafios\Database\MongoDbCollectionSchema;

class PointOfInterestCollectionSchema extends MongoDbCollectionSchema
{
    protected string $name = 'points-of-interest';

    protected array $indexes = [
        [
            'key' => ['point' => '2dsphere'],
            'name' => 'point_2dsphere',
            'sparse' => true,
            'background' => true,
        ],
    ];

    protected array $validator = [
        '$jsonSchema' => [
            'bsonType' => 'object',
            'required' => ['name', 'point'],
            'properties' => [
                'name' => [
                    'bsonType' => 'string',
                    'description' => 'must be a string and is required',
                ],
                'point' => [
                    'bsonType' => 'object',
                    'properties' => [
                        'type' => [
                            'enum' => ['Point'],
                            'description' => "'Point' is the only supported type",
                        ],
                        'coordinates' => [
                            'bsonType' => ['array'],
                            'minItems' => 2,
                            'maxItems' => 2,
                            'items' => [
                                [
                                    'bsonType' => ['double'],
                                    'description' => "must be a double and is required",
                                    'minimum' => -180,
                                    'maximum' => 180,
                                ],
                                [
                                    'bsonType' => ['double'],
                                    'description' => "must be a double and is required",
                                    'minimum' => -90,
                                    'maximum' => 90,
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ];
    
}
