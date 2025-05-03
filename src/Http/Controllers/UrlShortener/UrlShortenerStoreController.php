<?php

namespace Vluzrmos\BackendBr\Desafios\Http\Controllers\UrlShortener;

use Vluzrmos\BackendBr\Desafios\Database\UrlShortenerMongoDbFactory;
use Vluzrmos\BackendBr\Desafios\Http\JsonResponse;
use Vluzrmos\BackendBr\Desafios\Http\ResponseStatus;
use Vluzrmos\BackendBr\Desafios\Models\UrlShortener\Url;

class UrlShortenerStoreController
{
    public function __invoke()
    {
        $url = $_REQUEST['url'] ?? null;

        if (empty($url) || !filter_var($url, FILTER_VALIDATE_URL)) {
            return new JsonResponse(
                body: [
                    'error' => 'Invalid URL',
                ],
                status: ResponseStatus::BAD_REQUEST->value,
            );
        }

        $url = new Url(url: $url);

        try {
            $database = new UrlShortenerMongoDbFactory()->connection()->getDatabase();
            $url->save($database);
        } catch (\Exception $e) {
            return new JsonResponse(
                body: [
                    'error' => 'Failed to save URL',
                ],
                status: ResponseStatus::INTERNAL_SERVER_ERROR->value,
            );
        }

        return new JsonResponse(
            body: [
                'url' => $url->fullShortenUrl(),
                'shorten_id' => $url->shorten,
            ],
            status: ResponseStatus::CREATED->value,
        );
    }
}
