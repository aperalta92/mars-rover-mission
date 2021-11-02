<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Map;

class MapFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Map::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "width" => 5,
            "height" => 5,
            "matrix" => [[0,0,0,0,0],[0,1,1,0,1],[0,1,1,0,1],[0,0,0,0,0],[0,1,1,0,1]]
        ];
    }
}
