<?php

namespace Map\Application;

use Map\Domain\Contracts\MapRepositoryContract;
use Map\Domain\ValueObjects\MapId;

final class FindMapUseCase {
    /**
     * @var MapRepositoryContract
     */
    private $repository;

    /**
     * @param MapRepositoryContract $repository
     */
    public function __construct(MapRepositoryContract $repository) {
        $this->repository = $repository;
    }

    /**
     * @param int $id
     *
     * @return array|null
     */
    public function __invoke(int $id) : ?array {
        $id = new MapId($id);

        return $this->repository->find($id);
    }
}
