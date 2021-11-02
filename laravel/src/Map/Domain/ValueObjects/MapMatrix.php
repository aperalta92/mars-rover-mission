<?php

namespace Map\Domain\ValueObjects;

final class MapMatrix
{
    /**
     * @var int
     */
    private $value;

    /**
     * @param array $matrix
     */
    public function __construct(array $matrix) {
        $this->value = $matrix;
    }

        /**
     * @return array
     */
    public function value() : array {
        return $this->value;
    }
}
