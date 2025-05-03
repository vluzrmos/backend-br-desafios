<?php

namespace Vluzrmos\BackendBr\Desafios\Models\UrlShortener;

use Vluzrmos\BackendBr\Desafios\Database\MongoDbCollectionSchema;

class UrlCollectionSchema extends MongoDbCollectionSchema
{
    protected string $name = 'urls';

    protected array $indexes = [
        [
            'key' => ['shorten' => 1],
            'unique' => true,
            'sparse' => true,
            'background' => true,
        ],
    ];

    protected array $validator = [
        '$jsonSchema' => [
            'bsonType' => 'object',
            'required' => ['url', 'shorten'],
            'properties' => [
                'url' => [
                    'bsonType' => 'string',
                    'description' => 'must be a string and is required',
                ],
                'shorten' => [
                    'bsonType' => 'string',
                    'description' => 'must be a string and is required',
                ],
            ],
        ],
    ];
    
}
