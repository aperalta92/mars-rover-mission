<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rover extends Model {
    use HasFactory;

    /**
     * @var string
     */
    protected $table = "rovers";

    /**
     * @var string[]
     */
    protected $fillable = [
      "positionX",
      "positionY",
      "orientation"
    ];
}
