<?php

namespace Vluzrmos\BackendBr\Desafios\Http\Controllers\UrlShortener;

use Error;
use Vluzrmos\BackendBr\Desafios\Database\UrlShortenerMongoDbFactory;
use Vluzrmos\BackendBr\Desafios\Http\JsonResponse;
use Vluzrmos\BackendBr\Desafios\Http\RedirectResponse;
use Vluzrmos\BackendBr\Desafios\Http\ResponseStatus;
use Vluzrmos\BackendBr\Desafios\Models\UrlShortener\Url;
use Vluzrmos\BackendBr\Desafios\Models\UrlShortener\UrlCollectionSchema;

class UrlShortenerResolveController
{
    public function __invoke()
    {
        $shorten = $_REQUEST['shorten'] ?? null;

        if (empty($shorten)) {
            return new JsonResponse(
                body: [
                    'error' => 'Invalid Shorten URL',
                ],
                status: ResponseStatus::BAD_REQUEST->value,
            );
        }



        try {
            $database = new UrlShortenerMongoDbFactory()->connection()->getDatabase();
            $instance = $database->getCollection(new UrlCollectionSchema()->getName())->findOne([
                'shorten' => $shorten,
            ]);

            if (!$instance) {
                return new JsonResponse(
                    body: [
                        'error' => 'Shorten URL not found',
                    ],
                    status: ResponseStatus::NOT_FOUND->value,
                );
            }

            if (empty($instance->url)) {
                return new JsonResponse(
                    body: [
                        'error' => 'Invalid Shorten URL',
                    ],
                    status: ResponseStatus::BAD_REQUEST->value,
                );
            }

            $url = new Url(
                url: $instance->url,
                shorten: $instance->shorten,
            );
        } catch (\Exception $e) {
            return new JsonResponse(
                body: [
                    'error' => 'Failed to load URL',
                ],
                status: ResponseStatus::INTERNAL_SERVER_ERROR->value,
            );
        }

        return new RedirectResponse(
            url: $url->url,
            status: ResponseStatus::TEMPORARY_REDIRECT->value,
        );
    }
}
