<?php

namespace Tests\Feature;

use App\Models\Map;
use App\Models\Rover;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateRoverTest extends TestCase {
    use RefreshDatabase;

    /** @test */
    public function createRover()
    {
        $map = Map::factory()->create();
        $this->postJson("/api/v1/rover", $this->data($map->first()))
            ->assertStatus(201);

        $this->assertCount(1, Rover::all());
    }

    /**
     * @return int[]
     */
    private function data($map) : array {
        return [
            "mapId" => $map->id,
            "positionX" => 0,
            "positionY" => 0,
            "orientation" => "S"
        ];
    }
}
