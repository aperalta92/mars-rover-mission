<?php

namespace Tests\Feature;

use App\Models\Map;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateMapTest extends TestCase {
    use RefreshDatabase;

    /** @test */
    public function createMap()
    {
        $this->postJson("/api/v1/map", $this->data())
            ->assertStatus(201);

        $this->assertCount(1, Map::all());

        $this->json("GET", "/api/v1/map/1")
            ->assertStatus(200)
            ->assertJson([
                "width" => 5,
                "height" => 5,
                "matrix" => [[0,0,0,0,0],[0,1,1,0,1],[0,1,1,0,1],[0,0,0,0,0],[0,1,1,0,1]],
                "id" => 1
            ]);
    }

    /**
     * @return int[]
     */
    private function data() : array {
        return [
            "width" => 5,
            "height" => 5
        ];
    }
}
