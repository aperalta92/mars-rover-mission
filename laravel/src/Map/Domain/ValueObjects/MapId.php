<?php

namespace Map\Domain\ValueObjects;

use Map\Domain\Exceptions\MapException;

final class MapId
{
    /**
     * @var int
     */
    private $value;

    /**
     * @param int $id
     */
    public function __construct(int $id) {
        $this->validate($id);
        $this->value = $id;
    }

    private function validate(int $id) {
        if ($id < 1) {
            throw new MapException("ID cannot be less than 1");
        }
    }

    /**
     * @return int
     */
    public function value() : int {
        return $this->value;
    }
}
