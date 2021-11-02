<?php

namespace Map\Infrastructure;

use Map\Application\FindMapUseCase;
use Map\Infrastructure\Repositories\EloquentMapRepository;
use \Illuminate\Http\Request;
use \Map\Domain\Map;

final class FindMapController {
    /**
     * @var \Map\Infrastructure\Repositories\EloquentMapRepository
     */
    private $repository;

    /**
     * @param \Map\Infrastructure\Repositories\EloquentMapRepository $repository
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
        $id = $request->id;

        $findMapUseCase = new FindMapUseCase($this->repository);
        return $findMapUseCase($id);
    }
}
