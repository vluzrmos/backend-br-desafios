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

        $name = $_REQUEST['name'] ?? null;
        $x = $_REQUEST['x'] ?? null;
        $y = $_REQUEST['y'] ?? null;

        if (!$name) {
            $errors['name'] = ['Name is required'];
        }

        if (!is_numeric($x)) {
            $errors['x'] = ['X coordinate is required'];
        }

        if ($x < -180 || $x > 180) {
            $errors['x'] = ['X coordinate must be between -180 and 180'];
        }

        if (!is_numeric($y)) {
            $errors['y'] = ['Y coordinate is required'];
        }

        if ($y < -90 || $y > 90) {
            $errors['y'] = ['Y coordinate must be between -90 and 90'];
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

        
        try {
            $point->save($db->getDatabase());

        } catch (\Exception $e) {
            return new JsonResponse(
                body: [
                    'status' => 'error',
                    'errors' => [
                        'name' => ['Não foi possível salvar o ponto de interesse.'],
                    ],
                ],
                status: ResponseStatus::UNPROCESSABLE_ENTITY->value,
            );
        }

        return new JsonResponse(
            body: [
                'status' => 'ok',
            ],
            status: 201,
        );
    }
}
