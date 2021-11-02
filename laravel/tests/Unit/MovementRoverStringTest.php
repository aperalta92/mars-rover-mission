<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Rover\Domain\Exceptions\RoverInvalidMovementException;
use Rover\Domain\ValueObjects\RoverMovementString;

class MovementRoverStringTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testInvalidMovementRoverString()
    {
        $this->expectException(RoverInvalidMovementException::class);
        new RoverMovementString("X");
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testValidMovementRoverString()
    {
        $string = new RoverMovementString("F");
        $this->assertIsString($string->value());
    }
}
