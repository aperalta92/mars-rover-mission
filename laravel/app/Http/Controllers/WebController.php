<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebController extends Controller {

    public function app(Request $request) {
        return view('js.app');
    }
}
