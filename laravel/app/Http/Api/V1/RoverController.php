<?php

namespace App\Http\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Rover\Infrastructure\CreateRoverController;
use Rover\Infrastructure\MoveRoverController;

class RoverController {

    /**
     * @var CreateRoverController
     */
    private $createRoverController;

    /**
     * @var MoveRoverController
     */
    private $moveRoverController;

    public function __construct(
        CreateRoverController $createRoverController,
        MoveRoverController $moveRoverController
    ) {
        $this->createRoverController = $createRoverController;
        $this->moveRoverController = $moveRoverController;
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function createRover(Request $request) : Response {
        $rover = $this->createRoverController->__invoke($request);

        return response($rover, 201);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function moveRover(Request $request) {
        $movementArray = $this->moveRoverController->__invoke($request);

        return response($movementArray, 200);
    }
}
