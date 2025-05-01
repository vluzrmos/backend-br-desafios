<?php

namespace Vluzrmos\BackendBr\Desafios\Http\Controllers\PointsOfInterest;

use Vluzrmos\BackendBr\Desafios\Database\MongoDb;
use Vluzrmos\BackendBr\Desafios\Database\PointsOfInterestDb;
use Vluzrmos\BackendBr\Desafios\Database\PointsOfInterestMongoDbFactory;
use Vluzrmos\BackendBr\Desafios\Http\JsonResponse;
use Vluzrmos\BackendBr\Desafios\Http\ResponseStatus;
use Vluzrmos\BackendBr\Desafios\Models\PointsOfInterest\PointOfInterest;

class PointOfInterestNearController
{
    public function __invoke()
    {
        $db = new PointsOfInterestMongoDbFactory()->createMongoDb();

        $reference = new PointOfInterest(
            'Reference #'.uniqid(microtime(true),true),
            x: $_REQUEST['x'] ?? 0.0,
            y: $_REQUEST['y'] ?? 0.0,
        );

        $collection = $db->getDatabase()->getCollection('points-of-interest');

        $dmax = $_REQUEST['dmax'] ?? 10;

        // Convert dmax to meters
        $dmax = 100000 * (float) $dmax;


        $result = $collection->find([
                "point" => [
                    '$near' => [
                        '$geometry' => [
                            'type' => 'Point',
                            'coordinates' => [
                                $reference->x,
                                $reference->y,
                            ],
                        ],
                        '$maxDistance' => $dmax,
                    ]
                ]
            ]);

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
