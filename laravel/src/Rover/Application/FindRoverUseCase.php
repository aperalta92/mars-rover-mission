<?php

namespace Rover\Application;

use Rover\Domain\Contracts\RoverRepositoryContract;
use Rover\Domain\ValueObjects\RoverId;

final class FindRoverUseCase {

    /**
     * @var RoverRepositoryContract
     */
    private $repository;

    public function __construct(RoverRepositoryContract $repository) {
        $this->repository = $repository;
    }

    /**
     * @param int $id
     *
     * @return array|null
     */
    public function __invoke(int $id) : ?array {
        $roverId = new RoverId($id);

        return $this->repository->find($roverId);
    }
}
