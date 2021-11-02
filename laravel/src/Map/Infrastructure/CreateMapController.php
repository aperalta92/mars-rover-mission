<?php

namespace Map\Infrastructure;

use Illuminate\Http\Request;
use Map\Application\CreateMapUseCase;
use Map\Domain\Map;
use Map\Infrastructure\Repositories\EloquentMapRepository;

final class CreateMapController {
    /**
     * @var EloquentMapRepository
     */
    private $repository;

    /**
     * @param EloquentMapRepository $repository
     */
    public function __construct(EloquentMapRepository $repository) {
        $this->repository = $repository;
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function __invoke(Request $request) : array {
        $width = $request->width;
        $height = $request->height;

        $createMapUseCase = new CreateMapUseCase($this->repository);
        return $createMapUseCase($width, $height);
    }
}
