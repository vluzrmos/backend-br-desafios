<?php

namespace Vluzrmos\BackendBr\Desafios\Models\UrlShortener;

use MongoDB\Database;
use Vluzrmos\BackendBr\Desafios\Config\ConfigRepository;
use Vluzrmos\BackendBr\Desafios\Database\DatabaseManager;
use Vluzrmos\BackendBr\Desafios\Database\UrlShortenerMongoDbFactory;
use Vluzrmos\BackendBr\Desafios\Models\UrlShortener\UrlCollectionSchema;

class Url
{

    public function __construct(
        public string $url,
        public ?string $shorten = null,
    ) {
        //
    }

    public function getShortenUrlPathPrefix()
    {
        return ConfigRepository::instance()->get('app.shorten_url_path_prefix', 's');
    }

    public function fullShortenUrl()
    {
        $baseUrl = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
        $url = $protocol . '://' . $baseUrl .'/url-shortener/' . $this->shorten;
        
        return $url;
    }

    public function save(Database $database)
    {
        $schema = UrlCollectionSchema::instance();
        $collection = $database->getCollection($schema->getName());

        if (!$this->shorten) {
            $this->shorten = $this->createShortenHash();
        }

        return $collection->insertOne([
            'url' => $this->url,
            'shorten' => $this->shorten,
        ]);
    }

    public function createShortenHash(): string
    {
        $schema = UrlCollectionSchema::instance();

        $collection = new UrlShortenerMongoDbFactory()
            ->connection()
            ->getDatabase()
            ->getCollection($schema->getName());

        $shorten = random_string(5);
        $tries = 0;
        $minLength = 5;

        while ($collection->countDocuments(['shorten' => $shorten]) > 0) {
            $shorten = random_string($minLength);

            $tries++;

            if ($tries > 1 && $tries % 5 === 0) {
                $minLength++;
            }

            if ($tries > 50 || $minLength > 12) {
                throw new \Exception('Unable to generate a unique shorten URL');
            }
        }

        return $shorten;
    }
}
