<?php

namespace Rover\Application;

use Map\Application\FindMapUseCase;
use Map\Domain\Contracts\MapRepositoryContract;
use Rover\Domain\Contracts\RoverRepositoryContract;
use Rover\Domain\Rover;
use Rover\Domain\ValueObjects\RoverId;
use Rover\Domain\ValueObjects\RoverMovementString;
use Rover\Domain\ValueObjects\RoverOrientation;
use Rover\Domain\ValueObjects\RoverPositionX;
use Rover\Domain\ValueObjects\RoverPositionY;

final class MoveRoverUseCase {

    /**
     * @var RoverRepositoryContract
     */
    private $roverRepository;

    /**
     * @var MapRepositoryContract
     */
    private $mapRepository;

    public function __construct(RoverRepositoryContract $roverRepository, MapRepositoryContract $mapRepository) {
        $this->roverRepository = $roverRepository;
        $this->mapRepository = $mapRepository;
    }

    /**
     * @param int $mapId
     * @param int $id
     * @param string $movementString
     *
     * @return array
     */
    public function __invoke(
        int $mapId,
        int $id,
        string $movementString
    ) : array {
        $movementArray = str_split($movementString);
        $moveStringValuesArray = [];

        foreach ($movementArray as $moveString) {
            $moveStringValuesArray[] = new RoverMovementString($moveString);
        }

        $findMapUseCase = new FindMapUseCase($this->mapRepository);
        $map = $findMapUseCase($mapId);

        $findRoverUseCase = new FindRoverUseCase($this->roverRepository);
        $currentRover = $findRoverUseCase($id);

        $roverId = new RoverId($id);
        $roverPositionX = new RoverPositionX($currentRover["positionX"]);
        $roverPositionY = new RoverPositionY($currentRover["positionY"]);
        $roverOrientation = new RoverOrientation($currentRover["orientation"]);

        $rover = new Rover($roverPositionX, $roverPositionY, $roverOrientation, $roverId);
        return $this->roverRepository->move($map, $rover, $moveStringValuesArray);
    }
}
