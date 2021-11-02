<?php

namespace Map\Domain\Contracts;

use Map\Domain\Map;
use Map\Domain\ValueObjects\MapId;

interface MapRepositoryContract {

    public function find(MapId $id) : ?array;

    public function save(Map $map): array;
}
