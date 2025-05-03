<?php

namespace Vluzrmos\BackendBr\Desafios\Http\Controllers\PointsOfInterest;

use Vluzrmos\BackendBr\Desafios\Database\MongoDb;
use Vluzrmos\BackendBr\Desafios\Database\PointsOfInterestDb;
use Vluzrmos\BackendBr\Desafios\Database\PointsOfInterestMongoDbFactory;
use Vluzrmos\BackendBr\Desafios\Http\JsonResponse;
use Vluzrmos\BackendBr\Desafios\Http\ResponseStatus;
use Vluzrmos\BackendBr\Desafios\Models\PointsOfInterest\PointOfInterest;

class PointOfInterestIndexController
{
    public function __invoke()
    {
        $db = new PointsOfInterestMongoDbFactory()->connection();

        $result = $db->getDatabase()
            ->getCollection('points-of-interest')
            ->find();

        $points = [];

        foreach ($result as $item) {
            $points[] = new PointOfInterest(
                name: $item['name'],
                x: $item['point']['coordinates'][0],
                y: $item['point']['coordinates'][1],
            );
        }

        return new JsonResponse(
            body: [
                'points' => $points,
            ],
            status: ResponseStatus::OK->value,
        );
    }
}
