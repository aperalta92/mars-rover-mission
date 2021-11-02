<template>
    <div class="container">
        <div class="row">
            <div class="col-12">
                  <h1>Alex Peralta - Mars Rover Mission</h1>
            </div>
        </div>
    </div>
    <div class="mt-5" :class="map.matrix && map.matrix.length > 50 ? 'container-fluid' : 'container'">
        <div class="row">
            <div class="col-12">
                <h3>Map</h3>
                <template v-if="map.matrix.length > 0 && map.id">
                    <div :style="
                        {
                            'display': 'grid',
                            'grid-template-columns': 'repeat(' + positionY.length + ', 1fr)',
                            'grid-gap': '0',
                            'grid-auto-rows': '25px 25px',
                    }
                    " v-for="positionY in map.matrix">
                        <div class="border border-dark text-center" v-for="positionX in positionY">{{ positionX === 0 ? '' : (positionX === 2 ? rover.orientation : 'X') }}</div>
                    </div>
                </template>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row mt-5">
            <div class="col-12 d-flex flex-row">
                <div id="inputs" class="w-50 mt-5">
                    <form @submit="createMap" v-if="!map.id">
                        <h3>How big is our planet?</h3>
                        <small id="layout-warning" class="form-text text-warning">Warning: more than 100x100 can be unstable for the layout but the rover will be moved anyway.</small>
                        <small id="rover-info" class="form-text text-info">The rover is represented with the orientation letter.</small>
                        <div class="form-group mt-5">
                            <label for="map-width-input">Width *</label>
                            <input
                                id="map-width-input"
                                class="form-control"
                                type="number"
                                placeholder="Set the map width"
                                name="map-width"
                                v-model="map.width"
                                required
                            />
                        </div>
                        <div class="form-group">
                            <label for="map-height-input">Height *</label>
                            <input
                                id="map-height-input"
                                class="form-control"
                                type="number"
                                placeholder="Set the map height"
                                name="map-height"
                                v-model="map.height"
                                required
                            />
                        </div>
                        <button type="submit" class="btn btn-lg btn-primary" :disabled="!map.height || !map.width">Create Map</button>
                    </form>
                    <form @submit="createRover" v-if="!rover.id && map.id">
                        <h3>Where does the rover land?</h3>
                        <div class="form-group mt-5">
                            <label for="rover-position-x">Rover X Position *</label>
                            <input
                                id="rover-position-x"
                                class="form-control"
                                type="number"
                                placeholder="Set the rover x position"
                                name="rover-position-x"
                                v-model="rover.positionX"
                                required
                            />
                        </div>
                        <div class="form-group">
                            <label for="rover-position-y">Rover Y Position *</label>
                            <input
                                id="rover-position-y"
                                class="form-control"
                                type="number"
                                placeholder="Set the rover y position"
                                name="rover-position-y"
                                v-model="rover.positionY"
                                required
                            />
                        </div>
                        <div class="form-group">
                            <label for="rover-orientation">Rover Orientation *</label>
                            <input
                                id="rover-orientation"
                                class="form-control"
                                type="text"
                                placeholder="Set the rover orientation (N, S, E, W)"
                                name="rover-orientation"
                                maxlength="1"
                                pattern="^[NSEW]$"
                                v-model="rover.orientation"
                                required
                            />
                        </div>
                        <button type="submit" class="btn btn-lg btn-primary" :disabled="rover.positionX === undefined || rover.positionY === undefined || !rover.orientation">Create Rover</button>
                    </form>
                    <form @submit="moveRover" v-if="map.id && rover.id">
                        <h3>Let's move the rover!</h3>
                        <div class="form-group mt-5">
                            <label for="rover-input-string">Rover input string *</label>
                            <input
                                id="rover-input-string"
                                class="form-control"
                                type="text"
                                placeholder="Movement string (F, L, R)"
                                name="rover-input-string"
                                pattern="^[FLR]+$"
                                v-model="rover.inputString"
                                required
                            />
                        </div>
                        <button type="submit" class="btn btn-lg btn-primary" :disabled="!rover.inputString">Move Rover</button>
                    </form>
                </div>
                <div class="w-50 mt-5" v-if="logs !== ''">
                    <h3>Logs</h3>
                    <div class="border border-dark p-2" v-html="logs">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import { reactive, ref } from "vue"
import { default as RepositoryFactory } from "../repositories/RepositoryFactory"

export default {
    name: 'App',
    setup() {
        const map = reactive({
            matrix: reactive([])
        })
        const rover = reactive({})
        const mapRepository = RepositoryFactory.get("map")
        const roverRepository = RepositoryFactory.get("rover")
        let logs = ref("")

        let prevRover = {};

        function evaluateApiResponse(response) {
            console.log("response", response);
            return response.status >= 200 && response.status < 300;
        }

        function stopEvent(event) {
            event.preventDefault()
            event.stopPropagation()
        }

        function writeLog(success, text) {
            if (text === "") {
                logs.value = ""
            } else {
                logs.value += "<span class='text-" + (success ? "success" : "danger") + " font-weight-bold'>" + text + "</span><br />"
            }
        }

        function setRoverInMap() {
            if (prevRover.id) {
                map.matrix[prevRover.positionY][prevRover.positionX] = 0;
            }

            map.matrix[rover.positionY][rover.positionX] = 2;
        }

        async function createMap(event) {
            stopEvent(event)
            const createMapResponse = await mapRepository.createMap(map)

            if (evaluateApiResponse(createMapResponse)) {
                const responseMap = createMapResponse.data
                map.matrix = reactive(responseMap.matrix)
                map.id = responseMap.id
                console.log("map", map.matrix.value)
                writeLog(true, "Map created successfully")
            } else {
                writeLog(false, "Error creating the map")
            }
        }

        async function createRover(event) {
            stopEvent(event)
            let roverCreationBody = rover;
            roverCreationBody.mapId = map.id;

            const createRoverResponse = await roverRepository.createRover(roverCreationBody)

            if (evaluateApiResponse(createRoverResponse)) {
                const responseRover = createRoverResponse.data
                rover.id = responseRover.id
                setRoverInMap()

                writeLog(true, "Rover created successfully")
            } else {
                writeLog(false, "Error creating the rover")
            }
        }

        async function moveRover(event) {
            stopEvent(event)
            prevRover = { ...rover };

            let roverMovementBody = {
                mapId: map.id,
                movementString: rover.inputString
            }

            writeLog(true, "Moving rover with the sequence: " + prevRover.inputString)

            const moveRoverResponse = await roverRepository.moveRover(rover.id, roverMovementBody)

            if (evaluateApiResponse(moveRoverResponse)) {
                const responseRoverMovement = moveRoverResponse.data

                rover.positionX = responseRoverMovement.rover.positionX
                rover.positionY = responseRoverMovement.rover.positionY
                rover.orientation = responseRoverMovement.rover.orientation
                rover.inputString = ""
            }

            if (!moveRoverResponse.data.isCompleted) {
                console.log('prevRover', prevRover.positionX, prevRover.positionY);
                console.log('rover', rover.positionX, rover.positionY);
                writeLog(false, (prevRover.positionX !== rover.positionX || prevRover.positionY !== rover.positionY) ? moveRoverResponse.data.errorMsg + ", anyway, the rover has been moved from " + prevRover.positionX + ", " + prevRover.positionY + " to " + rover.positionX + ", " + rover.positionY + " and now is facing to " + rover.orientation : moveRoverResponse.data.errorMsg)
            } else {
                writeLog(true, "The rover has been moved successfully from " + prevRover.positionX + ", " + prevRover.positionY + " to " + rover.positionX + ', ' + rover.positionY + " and now is facing to " + rover.orientation)
            }

            setRoverInMap()
        }

        return {
            map: map,
            createMap: createMap,
            rover: rover,
            createRover: createRover,
            moveRover: moveRover,
            logs: logs
        }
    }
}
</script>

