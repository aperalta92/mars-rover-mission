<?php

namespace Rover\Infrastructure;

use Illuminate\Http\Request;
use Map\Infrastructure\Repositories\EloquentMapRepository;
use Rover\Application\MoveRoverUseCase;
use Rover\Infrastructure\Repositories\EloquentRoverRepository;

final class MoveRoverController {

    /**
     * @var EloquentMapRepository
     */
    private $mapRepository;

    /**
     * @var EloquentRoverRepository
     */
    private $roverRepository;

    public function __construct(EloquentMapRepository $mapRepository, EloquentRoverRepository $roverRepository) {
        $this->mapRepository = $mapRepository;
        $this->roverRepository = $roverRepository;
    }

    public function __invoke(Request $request) : array {
        $roverId = $request->roverId;
        $mapId = $request->mapId;
        $movementString = $request->movementString;

        $moveRoverUseCase = new MoveRoverUseCase($this->roverRepository, $this->mapRepository);
        return $moveRoverUseCase($mapId, $roverId, $movementString);
    }
}
