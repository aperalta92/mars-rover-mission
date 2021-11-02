<?php

namespace Map\Domain;

use Map\Domain\ValueObjects\MapHeight;
use Map\Domain\ValueObjects\MapId;
use Map\Domain\ValueObjects\MapMatrix;
use Map\Domain\ValueObjects\MapWidth;

final class Map {

    /**
     * @var \Map\Domain\ValueObjects\MapId | null
     */
    private $mapId;

    /**
     * @var \Map\Domain\ValueObjects\MapWidth
     */
    private $mapWidth;

    /**
     * @var \Map\Domain\ValueObjects\MapHeight
     */
    private $mapHeight;

    /**
     * @var \Map\Domain\ValueObjects\MapMatrix
     */
    private $mapMatrix;

    /**
     * @param \Map\Domain\ValueObjects\MapWidth $width
     * @param \Map\Domain\ValueObjects\MapHeight $height
     * @param \Map\Domain\ValueObjects\MapMatrix $matrix
     * @param \Map\Domain\ValueObjects\MapId|null $id
     */
    public function __construct(
        MapWidth $width,
        MapHeight $height,
        MapMatrix $matrix,
        MapId $id = null
    ) {
        $this->mapWidth = $width;
        $this->mapHeight = $height;
        $this->mapMatrix = $matrix;
        $this->mapId = $id;
    }

    /**
     * @return \Map\Domain\ValueObjects\MapId|null
     */
    public function id() : ?MapId {
        return $this->mapId;
    }

    /**
     * @return \Map\Domain\ValueObjects\MapWidth
     */
    public function width() : MapWidth {
        return $this->mapWidth;
    }

    /**
     * @return \Map\Domain\ValueObjects\MapHeight
     */
    public function height() : MapHeight {
        return $this->mapHeight;
    }

    /**
     * @return \Map\Domain\ValueObjects\MapMatrix|null
     */
    public function matrix() : ?MapMatrix {
        return $this->mapMatrix;
    }

    /**
     * @param \Map\Domain\ValueObjects\MapWidth $width
     * @param \Map\Domain\ValueObjects\MapHeight $height
     *
     * @return \Map\Domain\Map
     */
    public static function create(
        MapWidth $width,
        MapHeight $height,
        MapMatrix $mapMatrix
    ) : Map {
        return new self($width, $height, $mapMatrix);
    }
}
