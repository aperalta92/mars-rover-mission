<?php

namespace Map\Infrastructure\Repositories;

use App\Models\Map as EloquentMap;
use Map\Domain\Map;
use Map\Domain\Contracts\MapRepositoryContract;
use Map\Domain\ValueObjects\MapHeight;
use Map\Domain\ValueObjects\MapId;
use Map\Domain\ValueObjects\MapWidth;

final class EloquentMapRepository implements MapRepositoryContract {

    /**
     * @var \App\Models\Map
     */
    private $model;

    public function __construct() {
        $this->model = new EloquentMap();
    }

    /**
     * @param \Map\Domain\ValueObjects\MapId $id
     *
     * @return array
     */
    public function find(MapId $id) : ?array {
        $map = $this->model->findOrFail($id->value());

        return [
            "width" => $map->width,
            "height" => $map->height,
            "matrix" => $map->matrix,
            "id" => $map->id
        ];
    }

    /**
     * @param \Map\Domain\Map $map
     *
     * @return array
     */
    public function save(Map $map) : array {
        $model = $this->model->create([
            "width" => $map->width()->value(),
            "height" => $map->height()->value(),
            "matrix" => $map->matrix()->value()
        ]);

        return [
            "width" => $model->width,
            "height" => $model->height,
            "matrix" => $model->matrix,
            "id" => $model->id
        ];
    }
}
