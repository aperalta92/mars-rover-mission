<?php

namespace Map\Domain\ValueObjects;

final class MapWidth
{
    /**
     * @var int
     */
    private $value;

    /**
     * @param int $width
     */
    public function __construct(int $width) {
        $this->value = $width;
    }

    /**
     * @return int
     */
    public function value() : int {
        return $this->value;
    }
}
