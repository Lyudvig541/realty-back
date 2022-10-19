<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Partner;

class PartnerController extends Controller
{

    public function index(){

        $partners = Partner::offset(0)->limit(10)->get();
        return response()->json(compact('partners'));
    }
}
