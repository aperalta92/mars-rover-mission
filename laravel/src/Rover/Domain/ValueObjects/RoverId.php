<?php

namespace Rover\Domain\ValueObjects;

use Rover\Domain\Exceptions\RoverInvalidRoverIdException;

final class RoverId {

    /**
     * @var int
     */
    private $value;

    /**
     * @param int|null $id
     */
    public function __construct(?int $id) {
        $this->validate($id);
        $this->value = $id;
    }

    private function validate(int $id) {
        if (!is_null($id) && $id < 1) {
            throw new RoverInvalidRoverIdException("ID cannot be less than 1");
        }
    }

    /**
     * @return int|null
     */
    public function value() : ?int {
        return $this->value;
    }
}
