<?php

namespace App\Http\Api\V1;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Map\Infrastructure\CreateMapController;
use Map\Infrastructure\FindMapController;

class MapController extends Controller {

    /**
     * @var \Map\Infrastructure\CreateMapController
     */
    private $createMapController;

    private $findMapController;

    public function __construct(
        CreateMapController $createMapController,
        FindMapController $findMapController
    ) {
        $this->createMapController = $createMapController;
        $this->findMapController = $findMapController;
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function createMap(Request $request) : Response {
        $map = $this->createMapController->__invoke($request);

        return response($map, 201);
    }

    public function getMap(Request $request) : Response {
        $map = $this->findMapController->__invoke($request);

        return response($map, 200);
    }
}
