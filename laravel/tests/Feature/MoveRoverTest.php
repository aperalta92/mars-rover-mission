<?php

namespace Tests\Feature;

use App\Models\Map;
use App\Models\Rover;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MoveRoverTest extends TestCase {
    use RefreshDatabase;

    /** @test */
    public function moveRoverSuccessfully()
    {
        $map = Map::factory()->create();
        $rover = Rover::factory()->create();

        $this->postJson("/api/v1/rover/" . $rover->id . "/move", $this->dataSuccess($map->id))
            ->assertStatus(200)
            ->assertJson([
                "rover" => [
                    "positionX" => 3,
                    "positionY" => 3,
                    "orientation" => "E",
                    "id" => $rover->id
                ],
                "isCompleted" => true
            ]);
    }

     /** @test */
    public function moveRoverFailed()
    {
        $map = Map::factory()->create();
        $rover = Rover::factory()->create();

        $this->postJson("/api/v1/rover/" . $rover->id . "/move", $this->dataFail($map->id))
            ->assertStatus(200)
            ->assertJson([
                "rover" => [
                    "positionX" => 0,
                    "positionY" => 3,
                    "orientation" => "S",
                    "id" => $rover->id
                ],
                "isCompleted" => false,
                "errorMsg" => "The position -1, 3 is not valid"
            ]);
    }

    /**
     * @return int[]
     */
    private function dataSuccess($mapId) : array {
        return [
            "mapId" => $mapId,
            "movementString" => "FFFLFF"
        ];
    }

    /**
     * @return int[]
     */
    private function dataFail($mapId) : array {
        return [
            "mapId" => $mapId,
            "movementString" => "FFFRFF"
        ];
    }
}
