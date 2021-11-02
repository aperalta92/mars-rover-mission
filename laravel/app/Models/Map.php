<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Map extends Model {
    use HasFactory;

    /**
     * @var string
     */
    protected $table = "maps";

    /**
     * @var string[]
     */
    protected $fillable = [
        "width",
        "height",
        "matrix"
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        "matrix" => "json"
    ];
}
