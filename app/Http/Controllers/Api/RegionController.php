<?php

namespace App\Http\Controllers\Api;

use App\City;
use App\Http\Controllers\Controller;
use App\State;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    public function states(){
        $states = State::with('cities')->get();
        return response()->json(compact('states'));
    }
    public function cities(){
        $cities = City::all();
        return response()->json(compact('cities'));
    }

    public function useStates(){
        $states = State::with('cities')->get();
        $places_translations = [];
        $places = [];

        foreach ($states as $state){
            foreach ($state->translations as $translation){
                array_push($places_translations, ["id" => $state->id, "locale" => $translation->locale, "name" => $translation->name, "coordinates" => $state->coordinates,'map_zoom'=>$state->map_zoom]);
                foreach ($state->cities as $city){
                    array_push($places_translations, [
                        "id" => $state->id . ',' . $city->id,
                        "locale" => $translation->locale,
                        "name" => $city->translate($translation->locale)->name.', '. $state->translate($translation->locale)->name,
                        "coordinates" => $city->coordinates,
                        "map_zoom" => $city->map_zoom
                    ]);
                }
            }

        }
        foreach ($places_translations as $key => $value){
            array_push($places, [
                'key' => $key,
                'id' => $value['id'],
                'name' => $value['name'],
                'locale' => $value['locale'],
                'map_zoom' => $value['map_zoom'],
                'coordinates' => $value['coordinates'],
            ]);
        }
        return response()->json(compact('places'));
    }

    public function useCities(){
        $cities = City::all();
        return response()->json(compact('cities'));
    }
}
