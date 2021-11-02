<?php

namespace Rover\Domain\ValueObjects;

final class RoverPositionX
{
    /**
     * @var int
     */
    private $value;

    /**
     * @param int $positionX
     */
    public function __construct(int $positionX) {
        $this->value = $positionX;
    }

    /**
     * @return int
     */
    public function value() : int {
        return $this->value;
    }

}
