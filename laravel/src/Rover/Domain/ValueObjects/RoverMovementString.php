<?php

namespace Rover\Domain\ValueObjects;

use Rover\Domain\Exceptions\RoverInvalidMovementException;

final class RoverMovementString {

     /**
     * @var string
     */
    private $value;

    /**
     * @var string[]
     */
    private $acceptedMovements = ['F', 'L', 'R'];

    /**
     * @param string $movement
     */
    public function __construct(string $movement) {
        $this->validate($movement);
        $this->value = $movement;
    }

    /**
     * @return string
     */
    public function value(): string {
        return $this->value;
    }

    /**
     * @param string $movement
     */
    private function validate(string $movement) {
        if (!in_array($movement, $this->acceptedMovements)) {
            throw new RoverInvalidMovementException("The movement string is not valid.");
        }
    }
}
