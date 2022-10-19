<?php

namespace App\Http\Controllers\Api;

use App\Constructor;
use App\Currency;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;


class ConstructorController extends Controller
{

    public function constructors(Request $request){

        $arr = [];

        if ($request->input('data.maxPrice')) {
            array_push($arr,['price_end', '<=', $request->input('data.maxPrice')]);
        }
        if ($request->input('data.minPrice')) {
            array_push($arr,['price_start', '>=', $request->input('data.minPrice')]);
        }
        if ($request->input('data.currency')) {
            array_push($arr,['currency_id', (int)$request->input('data.currency')]);
        }
        if ($request->input('data.constAgency')) {
            array_push($arr,['const_agency_id', (int)$request->input('data.constAgency')]);
        }
        if ($request->input('data.region')) {
            array_push($arr,['state_id',(int)$request->input('data.region')]);
        }
        if ($request->input('data.deadline') && $request->input('data.deadline') === 'finished') {
            array_push($arr,['end_date','<=', Carbon::now()->format('d-m-Y')]);
        }
        if ($request->input('data.deadline') && $request->input('data.deadline') === 'current') {
            array_push($arr,['end_date','>',  Carbon::now()->format('d-m-Y')]);
        }
        $constructions = Constructor::where($arr)->with('constructorImages','constAgency','currency')->orderBy('id', 'desc')->paginate(3);
        $currencies = Currency::all();
        return response()->json(compact('constructions','currencies'));
    }
    public function constructor(Request $request){
        $currencies = Currency::all();
        $construction = Constructor::query()->where('id', $request->id)->with('constructorImages', 'constAgency.state', 'constAgency.city', 'currency')->first();
        return response()->json(compact('construction','currencies'));
    }
    public function allConstructors(Request $request){
        $query = Constructor::query();
        if($request->region){
            $query->where('state_id',$request->region);
        }
        $constructions = $query->with('currency')->get();
        return response()->json(compact('constructions'));
    }

}

