<?php

namespace Rover\Infrastructure\Repositories;

use Rover\Domain\Contracts\RoverRepositoryContract;
use Rover\Domain\Exceptions\RoverInvalidPositionException;
use Rover\Domain\Rover;
use App\Models\Rover as EloquentRover;
use Rover\Domain\ValueObjects\RoverId;
use Rover\Domain\ValueObjects\RoverMovementString;
use Rover\Domain\ValueObjects\RoverOrientation;
use Rover\Domain\ValueObjects\RoverPositionX;
use Rover\Domain\ValueObjects\RoverPositionY;

final class EloquentRoverRepository implements RoverRepositoryContract {

    /**
     * @var \App\Models\Rover
     */
    private $model;

    public function __construct(EloquentRover $rover) {
        $this->model = $rover;
    }

    public function find(RoverId $id) : ?array {
        $rover = $this->model->findOrFail($id->value());

        return [
          "id" => $rover->id,
          "positionX" => $rover->positionX,
          "positionY" => $rover->positionY,
          "orientation" => $rover->orientation
        ];
    }

    public function create(array $map, Rover $rover) : array {
        $this->validatePosition($map, $rover);
        $model = $this->model->create($this->createModelAttributesArray($rover));

        return [
            "id" => $model->id,
            "positionX" => $model->positionX,
            "positionY" => $model->positionY,
            "orientation" => $model->orientation
        ];
    }

    /**
     * @param \Rover\Domain\Rover $rover
     *
     */
    private function updatePosition(Rover $rover) : void {
        $model = $this->model->find($rover->id()->value());
        $model->fill($this->createModelAttributesArray($rover));
        $model->save();
    }

    /**
     * @param Rover $rover
     *
     * @return array
     */
    private function createModelAttributesArray (Rover $rover) : array {
        return [
            "positionX" => $rover->positionX()->value(),
            "positionY" => $rover->positionY()->value(),
            "orientation" => $rover->orientation()->value(),
            "id" => $rover->id() ? $rover->id()->value() : null
        ];
    }

    /**
     * @param array $map
     * @param Rover $rover
     * @param array $movementStringArray
     *
     * @return array
     */
    public function move(array $map, Rover $rover, array $movementStringArray) : array {
        $isCompleted = true;
        $errorMsg = "";
        foreach ($movementStringArray as $movementString) {
            try {
                $rover = $this->calculatePositionMovement($map, $rover, $movementString);
                $this->updatePosition($rover);
            } catch (RoverInvalidPositionException $exception) {
                $errorMsg = $exception->getMessage();
                $isCompleted = false;
                break;
            }
        }

        $roverArr = $this->createModelAttributesArray($rover);

        $result = [
            "rover" => $roverArr,
            "isCompleted" => $isCompleted
        ];

        if (!$result['isCompleted']) {
            $result["errorMsg"] = $errorMsg;
        }

        return $result;
    }

    /**
     * @param array $map
     * @param Rover $rover
     * @param RoverMovementString $movementString
     *
     * @return Rover
     */
    private function calculatePositionMovement(array $map, Rover $rover, RoverMovementString $movementString) : Rover {

        /*
        if ($movementString->value() === "F") {
            switch ($rover->orientation()->value()) {
                case "N":
                    $rover = $this->moveY($rover, -1);
                break;

                case "S":
                    $rover = $this->moveY($rover, 1);
                break;

                case "E":
                    $rover = $this->moveX($rover, 1);
                break;

                case "W":
                    $rover = $this->moveX($rover, -1);
                break;
            }

            $this->validatePosition($map, $rover);

        } else if ($movementString->value() === "L") {
            switch ($rover->orientation()->value()) {
                case "N":
                    $rover = $this->moveX($rover, -1, "W");
                break;

                case "S":
                    $rover = $this->moveX($rover, 1, "E");
                break;

                case "E":
                    $rover = $this->moveY($rover, -1, "N");
                break;

                case "W":
                    $rover = $this->moveY($rover, 1, "S");
                break;
            }
        } else {
            switch ($rover->orientation()->value()) {
                case "N":
                    $rover = $this->moveX($rover, 1, "E");
                break;

                case "S":
                    $rover = $this->moveX($rover, -1, "W");
                break;

                case "E":
                    $rover = $this->moveY($rover, 1, "S");
                break;

                case "W":
                    $rover = $this->moveY($rover, -1, "N");
                break;
            }
        }
        */

        /**
         *
         * Instead of all the logic we can see above, we are indexing into an associative array
         * the value of the movement string with all its orientation possibilities
         * and what the rover should do later
         *
         */
        $indexedMovementPossibilites = [
            "F" => [
                "N" => $this->createMovementPossibilitiesArray(-1, "moveY"),
                "S" => $this->createMovementPossibilitiesArray(1, "moveY"),
                "E" => $this->createMovementPossibilitiesArray(1, "moveX"),
                "W" => $this->createMovementPossibilitiesArray(-1, "moveX")
            ],
            "L" => [
                "N" => $this->createMovementPossibilitiesArray(-1, "moveX", "W"),
                "S" => $this->createMovementPossibilitiesArray(1, "moveX", "E"),
                "E" => $this->createMovementPossibilitiesArray(-1, "moveY", "N"),
                "W" => $this->createMovementPossibilitiesArray(1, "moveY", "S")
            ],
            "R" => [
                "N" => $this->createMovementPossibilitiesArray(1, "moveX", "E"),
                "S" => $this->createMovementPossibilitiesArray(-1, "moveX", "W"),
                "E" => $this->createMovementPossibilitiesArray(1, "moveY", "S"),
                "W" => $this->createMovementPossibilitiesArray(-1, "moveY", "N")
            ]
        ];

        $rover = $this->
                {$indexedMovementPossibilites[$movementString->value()][$rover->orientation()->value()]["axis"]} (
                    $rover,
                    $indexedMovementPossibilites[$movementString->value()][$rover->orientation()->value()]["direction"],
                    $indexedMovementPossibilites[$movementString->value()][$rover->orientation()->value()]["orientation"]
                );


        $this->validatePosition($map, $rover);

        return $rover;
    }

    /**
     * @param int $direction
     * @param string $axis
     * @param string|null $orientation
     *
     * @return array
     */
    private function createMovementPossibilitiesArray(int $direction, string $axis, string $orientation = null) : array {
        return [
            "direction" => $direction,
            "axis" => $axis,
            "orientation" => $orientation
        ];
    }

    /**
     * @param Rover $rover
     * @param int $direction
     * @param string|null $newOrientation
     *
     * @return Rover
     */
    private function moveX(Rover $rover, int $direction, string $newOrientation = null) : Rover {
        $newPositionX = new RoverPositionX($rover->positionX()->value() + $direction);
        $orientation = $this->setNewOrientation($rover, $newOrientation);

        return new Rover($newPositionX, $rover->positionY(), $orientation, $rover->id());
    }

    /**
     * @param Rover $rover
     * @param int $direction
     * @param string|null $newOrientation
     *
     * @return Rover
     */
    private function moveY(Rover $rover, int $direction, string $newOrientation = null) : Rover {
        $newPositionY = new RoverPositionY($rover->positionY()->value() + $direction);
        $orientation = $this->setNewOrientation($rover, $newOrientation);

        return new Rover($rover->positionX(), $newPositionY, $orientation, $rover->id());
    }

    /**
     * @param Rover $rover
     * @param string|null $newOrientation
     *
     * @return RoverOrientation
     */
    private function setNewOrientation(Rover $rover, string $newOrientation = null) : RoverOrientation {
        $orientation = $rover->orientation();
        if (!is_null($newOrientation)) {
            $orientation = new RoverOrientation($newOrientation);
        }

        return $orientation;
    }

    /**
     * @param array $map
     * @param Rover $rover
     */
    private function validatePosition(array $map, Rover $rover) : void {
        if (
            !isset($map["matrix"][$rover->positionY()->value()][$rover->positionX()->value()]) ||
            $map["matrix"][$rover->positionY()->value()][$rover->positionX()->value()] === 1
        ) {
            throw new RoverInvalidPositionException("The position " . $rover->positionX()->value() . ", " . $rover->positionY()->value() . " is not valid");
        }
    }

}
