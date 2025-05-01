<?php

namespace Vluzrmos\BackendBr\Desafios\Http\Controllers\PointsOfInterest;

use Vluzrmos\BackendBr\Desafios\Database\MongoDb;
use Vluzrmos\BackendBr\Desafios\Database\PointsOfInterestDb;
use Vluzrmos\BackendBr\Desafios\Database\PointsOfInterestMongoDbFactory;
use Vluzrmos\BackendBr\Desafios\Http\JsonResponse;
use Vluzrmos\BackendBr\Desafios\Http\ResponseStatus;
use Vluzrmos\BackendBr\Desafios\Models\PointsOfInterest\PointOfInterest;

class PointOfInterestStoreController
{
    public function __invoke()
    {
        $errors = [];

        if (!($_REQUEST['name'] ?? null)) {
            $errors['name'] = ['Name is required'];
        }

        if (!is_numeric($_REQUEST['x'] ?? null)) {
            $errors['x'] = ['X coordinate is required'];
        }

        if (!is_numeric($_REQUEST['y'] ?? null)) {
            $errors['y'] = ['Y coordinate is required'];
        }

        if ($errors) {
            return new JsonResponse(
                body: [
                    'status' => 'error',
                    'errors' => $errors,
                ],
                status: ResponseStatus::UNPROCESSABLE_ENTITY->value,
            );
        }

        $point = new PointOfInterest(
            name: $_REQUEST['name'] ?? 'Test',
            x: $_REQUEST['x'] ?? 0.0,
            y: $_REQUEST['y'] ?? 0.0,
        );

        $db = new PointsOfInterestMongoDbFactory()->createMongoDb();

        $result = $point->save($db->getDatabase());

        return new JsonResponse(
            body: [
                'status' => 'ok',
            ],
            status: 201,
        );
    }
}
