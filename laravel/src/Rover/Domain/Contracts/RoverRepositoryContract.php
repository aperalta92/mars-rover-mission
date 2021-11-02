<?php

namespace Rover\Domain\Contracts;

use Rover\Domain\Rover;
use Rover\Domain\ValueObjects\RoverId;

interface RoverRepositoryContract {

    public function find(RoverId $id) : ?array;

    public function create(array $map, Rover $rover) : array;
}
