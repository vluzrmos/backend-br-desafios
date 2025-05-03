<?php

namespace Vluzrmos\BackendBr\Desafios\Database;

use Vluzrmos\BackendBr\Desafios\Models\UrlShortener\UrlCollectionSchema;

class UrlShortenerMongoDbFactory extends MongoDbFactory
{
    protected $connection = 'url-shortener';

    public function getCollectionSchemas()
    {
        return [
            UrlCollectionSchema::instance(),
        ];
    }
}
