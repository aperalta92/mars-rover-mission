<?php

namespace Map\Domain\ValueObjects;

final class MapHeight
{
    /**
     * @var int
     */
    private $value;

    /**
     * @param int $height
     */
    public function __construct(int $height) {
        $this->value = $height;
    }

    /**
     * @return int
     */
    public function value() : int {
        return $this->value;
    }
}
