<?php

namespace Rover\Infrastructure;

use Illuminate\Http\Request;
use Map\Infrastructure\Repositories\EloquentMapRepository;
use Rover\Application\CreateRoverUseCase;
use Rover\Infrastructure\Repositories\EloquentRoverRepository;

final class CreateRoverController {

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

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function __invoke(Request $request) : array {
        $mapId = $request->mapId;
        $positionX = $request->positionX;
        $positionY = $request->positionY;
        $orientation = $request->orientation;

        $createRoverUseCase = new CreateRoverUseCase($this->roverRepository, $this->mapRepository);
        return $createRoverUseCase($mapId, $positionX, $positionY, $orientation);
    }
}
