<?php

namespace Rover\Domain;

use Rover\Domain\ValueObjects\RoverOrientation;
use Rover\Domain\ValueObjects\RoverPositionX;
use Rover\Domain\ValueObjects\RoverPositionY;
use Rover\Domain\ValueObjects\RoverId;

final class Rover {

    /**
     * @var RoverId|null
     */
    private $id;

    /**
     * @var RoverPositionX
     */
    private $positionX;

    /**
     * @var RoverPositionY
     */
    private $positionY;

    /**
     * @var RoverOrientation
     */
    private $orientation;

    /**
     * @param \Rover\Domain\ValueObjects\RoverPositionX $positionX
     * @param \Rover\Domain\ValueObjects\RoverPositionY $positionY
     * @param \Rover\Domain\ValueObjects\RoverOrientation $orientation
     */
    public function __construct(RoverPositionX $positionX, RoverPositionY $positionY, RoverOrientation $orientation, RoverId $id = null) {
        $this->positionX = $positionX;
        $this->positionY = $positionY;
        $this->orientation = $orientation;
        $this->id = $id;
    }

    /**
     * @return RoverId|null
     */
    public function id() : ?RoverId {
        return $this->id;
    }

    /**
     * @return RoverPositionX
     */
    public function positionX() : RoverPositionX {
        return $this->positionX;
    }

    /**
     * @return RoverPositionY
     */
    public function positionY() : RoverPositionY {
        return $this->positionY;
    }

    /**
     * @return RoverOrientation
     */
    public function orientation() : RoverOrientation {
        return $this->orientation;
    }

    /**
     * @param RoverPositionX $positionX
     * @param RoverPositionY $positionY
     * @param RoverOrientation $orientation
     * @param RoverId|null $id
     *
     * @return Rover
     */
    public static function create(
        RoverPositionX $positionX,
        RoverPositionY $positionY,
        RoverOrientation $orientation,
        RoverId $id = null
    ) : Rover {
        return new self($positionX, $positionY, $orientation, $id);
    }
}
