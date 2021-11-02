<?php

namespace Rover\Domain\ValueObjects;

use Rover\Domain\Exceptions\RoverInvalidOrientationException;

final class RoverOrientation {
    /**
     * @var string
     */
    private $value;

    /**
     * @var string[]
     */
    private $acceptedOrientations = ['N', 'S', 'E', 'W'];

    /**
     * @param string $orientation
     */
    public function __construct(string $orientation) {
        $this->validate($orientation);
        $this->value = $orientation;
    }

    /**
     * @return string
     */
    public function value(): string {
        return $this->value;
    }

    /**
     * @param string $orientation
     */
    private function validate(string $orientation) {
        if (!in_array($orientation, $this->acceptedOrientations)) {
            throw new RoverInvalidOrientationException("The introduced orientation is not valid.");
        }
    }

}
