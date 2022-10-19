<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Country;
use App\Http\Controllers\Controller;
use App\State;
use Illuminate\Http\Request;

class StateController extends Controller
{

    public function index()
    {
        $states = State::paginate(10);
        return view('admin.settings.state.index', compact('states'));
    }


    public function create()
    {
        $countries = Country::get();
        $languages = config('translatable.locales');
        return view('admin.settings.state.create', compact('countries', 'languages'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name_am' => 'required|string',
            'name_en' => 'required|string',
            'name_ru' => 'required|string',
            'country' => 'required',
            'coordinates' => 'required',
            'map_zoom' => 'required|integer'

        ]);

        $data = [
            'country_id' => $request->country,
            'coordinates' => $request->coordinates,
            'map_zoom' => $request->map_zoom,
        ];

        foreach (config('translatable.locales') as $locale){
            $data[$locale] = ['name' => $request->{'name_'.$locale}];
        }

        State::create($data);

        toastr()->success("State saved!");

        return redirect('/admin/settings/states');

    }


    public function edit($id)
    {
        $state = State::find($id);
        $countries = Country::get();
        $languages = config('translatable.locales');
        return view('admin.settings.state.edit', compact('state', 'countries', 'languages'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name_am' => 'required|string',
            'name_en' => 'required|string',
            'name_ru' => 'required|string',
            'country' => 'required',
            'coordinates' => 'required',
            'map_zoom' => 'required|integer'

        ]);

        $data = [
            'country_id' => $request->country,
            'coordinates' => $request->coordinates,
            'map_zoom' => $request->map_zoom,

        ];

        foreach (config('translatable.locales') as $locale){
            $data[$locale] = ['name' => $request->{'name_'.$locale}];
        }

        $type = State::findOrFail($id);
        $type->update($data);

        toastr()->success("State updated!");

        return redirect('/admin/settings/states');
    }


    public function destroy($id)
    {
        State::where('id', $id)->delete();

        toastr()->success("State deleted!");

        return redirect('/admin/settings/states')->with('success','State deleted!');
    }
}
