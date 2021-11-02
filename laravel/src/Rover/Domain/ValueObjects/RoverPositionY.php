<?php

namespace Rover\Domain\ValueObjects;

final class RoverPositionY
{
    /**
     * @var int
     */
    private $value;

    /**
     * @param int $positionY
     */
    public function __construct(int $positionY) {
        $this->value = $positionY;
    }

    /**
     * @return int
     */
    public function value() : int {
        return $this->value;
    }

}
