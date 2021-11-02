<?php

namespace Rover\Application;

use Map\Domain\Contracts\MapRepositoryContract;
use Rover\Domain\Contracts\RoverRepositoryContract;
use Rover\Domain\Rover;
use Rover\Domain\ValueObjects\RoverOrientation;
use Rover\Domain\ValueObjects\RoverPositionX;
use Rover\Domain\ValueObjects\RoverPositionY;
use Map\Application\FindMapUseCase;

final class CreateRoverUseCase {

    /**
     * @var \Rover\Domain\Contracts\RoverRepositoryContract
     */
    private $roverRepository;

    /**
     * @var \Map\Domain\Contracts\MapRepositoryContract
     */
    private $mapRepository;

    public function __construct(RoverRepositoryContract $roverRepository, MapRepositoryContract $mapRepository) {
        $this->roverRepository = $roverRepository;
        $this->mapRepository = $mapRepository;
    }

    /**
     * @param int $mapId
     * @param int $positionX
     * @param int $positionY
     * @param string $orientation
     *
     * @return array
     */
    public function __invoke(
        int $mapId,
        int $positionX,
        int $positionY,
        string $orientation
    ) : array {
        $roverPositionX = new RoverPositionX($positionX);
        $roverPositionY = new RoverPositionY($positionY);
        $roverOrientation = new RoverOrientation($orientation);

        $findMapUseCase = new FindMapUseCase($this->mapRepository);
        $map = $findMapUseCase($mapId);

        $rover = new Rover($roverPositionX, $roverPositionY, $roverOrientation);
        return $this->roverRepository->create($map, $rover);
    }
}
