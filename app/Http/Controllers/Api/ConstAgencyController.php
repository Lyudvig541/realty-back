<?php

namespace App\Http\Controllers\Api;

use App\ConstAgency;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;



class ConstAgencyController extends Controller
{

    public function constAgency(Request $request){
        $const_agency = ConstAgency::query()->where('id', (int)$request->id)->
        with( 'country', 'state', 'city')->first();;
        return response()->json(compact('const_agency'));
    }

    public function all(){
        $const_agencies = ConstAgency::all();
        return response()->json(compact('const_agencies'));
    }
}

