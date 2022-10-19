<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{

    public function index()
    {
        $countries = Country::paginate(10);
        return view('admin.settings.country.index', compact('countries'));
    }


    public function create()
    {
        $languages = config('translatable.locales');
        return view('admin.settings.country.create', compact( 'languages'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name_am' => 'required|string',
            'name_en' => 'required|string',
            'name_ru' => 'required|string',
            'coordinates' => 'required',
        ]);

        $data = [
            'coordinates' => $request->coordinates,
        ];

        foreach (config('translatable.locales') as $locale){
            $data[$locale] = ['name' => $request->{'name_'.$locale}];
        }

        Country::create($data);

        toastr()->success("Country saved!");

        return redirect('/admin/settings/countries');

    }


    public function edit($id )
    {
        $country = Country::find($id);
        $languages = config('translatable.locales');
        return view('admin.settings.country.edit', compact('country', 'languages'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name_am' => 'required|string',
            'name_en' => 'required|string',
            'name_ru' => 'required|string',
            'coordinates' => 'required',
        ]);

        $data = [
            'coordinates' => $request->coordinates,
        ];

        foreach (config('translatable.locales') as $locale){
            $data[$locale] = ['name' => $request->{'name_'.$locale}];
        }

        $country = Country::findOrFail($id);
        $country->update($data);

        toastr()->success("Country updated!");

        return redirect('/admin/settings/countries');
    }


    public function destroy($id)
    {
        Country::where('id', $id)->delete();

        toastr()->success("Country deleted!");

        return redirect('/admin/settings/countries')->with('success', 'Country deleted!');
    }
}
