<?php

namespace App\Http\Controllers\Admin\Settings;

use App\City;
use App\State;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CityController extends Controller
{

    public function index()
    {
        $cities = City::paginate(10);
        return view('admin.settings.city.index', compact('cities'));
    }


    public function create()
    {
        $states = State::get();
        $languages = config('translatable.locales');
        return view('admin.settings.city.create', compact('states', 'languages'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name_am' => 'required|string',
            'name_en' => 'required|string',
            'name_ru' => 'required|string',
            'state' => 'required',
            'coordinates' => 'required',
            'map_zoom' => 'required|integer'
        ]);

        $data = [
            'state_id' => $request->state,
            'coordinates' => $request->coordinates,
            'map_zoom' => $request->map_zoom,
        ];

        foreach (config('translatable.locales') as $locale){
            $data[$locale] = ['name' => $request->{'name_'.$locale}];
        }

        City::create($data);

        toastr()->success("City saved!");

        return redirect('/admin/settings/cities');

    }


    public function edit($id )
    {
        $city = City::find($id);
        $states = State::get();
        $languages = config('translatable.locales');
        return view('admin.settings.city.edit', compact('states', 'city', 'languages'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name_am' => 'required|string',
            'name_en' => 'required|string',
            'name_ru' => 'required|string',
            'state' => 'required',
            'coordinates' => 'required',
            'map_zoom' => 'required|integer'
        ]);

        $data = [
            'state_id' => $request->state,
            'coordinates' => $request->coordinates,
            'map_zoom' => $request->map_zoom,
        ];

        foreach (config('translatable.locales') as $locale){
            $data[$locale] = ['name' => $request->{'name_'.$locale}];
        }

        $city = City::findOrFail($id);
        $city->update($data);

        toastr()->success("City updated!");

        return redirect('/admin/settings/cities');
    }


    public function destroy($id)
    {
        City::where('id', $id)->delete();

        toastr()->success("City deleted!");

        return redirect('/admin/settings/cities')->with('success','City deleted!');
    }

    public function cityByStateId(Request $request)
    {
        $state = State::where('id',$request->state_id)->first();
       $cities = City::where('state_id', $request->state_id)->get();
       return response()->json(compact('cities','state'));
    }
    public function cityAndStateById(Request $request)
    {
        $state = State::where('id',$request->state_id)->first();
       $city = City::where('id', $request->city_id)->first();
       return response()->json(compact('city','state'));
    }
}
