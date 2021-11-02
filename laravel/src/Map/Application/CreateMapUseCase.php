<?php

namespace Map\Application;

use Map\Domain\Contracts\MapRepositoryContract;
use Map\Domain\Map;
use Map\Domain\ValueObjects\MapHeight;
use Map\Domain\ValueObjects\MapMatrix;
use Map\Domain\ValueObjects\MapWidth;

final class CreateMapUseCase {
    /**
     * @var \Map\Domain\Contracts\MapRepositoryContract
     */
    private $repository;

    /**
     * @param \Map\Domain\Contracts\MapRepositoryContract $repository
     */
    public function __construct(MapRepositoryContract $repository) {
        $this->repository = $repository;
    }

    /**
     * @param int $width
     * @param int $height
     *
     * @return array
     */
    public function __invoke(
        int $width,
        int $height
    ) : array {
        $width = new MapWidth($width);
        $height = new MapHeight($height);

        $mapMatrix = $this->createMatrix($width, $height);
        $matrix = new MapMatrix($mapMatrix);

        $map = Map::create($width, $height, $matrix);
        return $this->repository->save($map);
    }

    /**
     * @param \Map\Domain\ValueObjects\MapWidth $width
     * @param \Map\Domain\ValueObjects\MapHeight $height
     *
     * @return array
     */
    private function createMatrix(MapWidth $width, MapHeight $height) : array {
        $matrix = [];

        for ($i = 0; $i < $height->value(); ++$i) {
            $row = [];
            for ($j = 0; $j < $width->value(); ++$j) {
                if ($j % 3 && $i % 3) {
                    array_push($row, 1); // obstacle
                } else {
                    array_push($row, 0); // empty
                }
            }
            array_push($matrix, $row);
        }

        return $matrix;
    }
}
