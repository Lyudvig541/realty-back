<?php

namespace App\Http\Controllers\Admin;

use App\City;
use App\Country;
use App\Http\Controllers\Controller;
use App\ConstAgency;
use App\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ConstAgencyController extends Controller
{

    public function index(){
        $constructor_agencies = ConstAgency::paginate(10);
        return view('admin.constructor_agency.index', compact('constructor_agencies'));
    }

    public function create(){
        $constructor_agencies = ConstAgency::all();
        $countries = Country::get();
        $states = State::get();
        $languages = config('translatable.locales');
        return view('admin.constructor_agency.create', compact('constructor_agencies', 'languages', 'countries', 'states'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'name_am' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'name_ru' => 'required|string|max:255',
            'phone' => 'required|max:20|min:6|unique:agencies',
            'description_am' => 'required|string',
            'description_en' => 'required|string',
            'description_ru' => 'required|string',
            'image' => 'mimes:png,jpg,jpeg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image');
            $imageName =  time().'_'.$imagePath->getClientOriginalName();
            $request->file('image')->storeAs('uploads/constructor_agencies', $imageName, 'public');
        }else{
            $imageName = null;
        }

        $data = [
            'image' => $imageName,
            'phone' => $request->phone,
            'email' => $request->email,
            'country_id' => $request->country_id,
            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
        ];


        foreach (config('translatable.locales') as $locale){
            $data[$locale] = [
                'name' => $request->{'name_'.$locale},
                'description' => $request->{'description_'.$locale}
            ];
        }

        ConstAgency::create($data);

        toastr()->success("Constructor Agency saved!");

        return redirect('/admin/constructor_agencies');
    }


    public function edit($id){
        $constructor_agency = ConstAgency::find($id);
        $countries = Country::get();
        $states = State::get();
        $cities = City::where('state_id', $constructor_agency->state_id)->get();
        $languages = config('translatable.locales');
        return view('admin.constructor_agency.edit', compact('constructor_agency', 'languages', 'countries', 'states', 'cities'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'name_am' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'name_ru' => 'required|string|max:255',
            'phone' => 'required|max:20|min:6|unique:agencies,phone,'.$id,
            'description_am' => 'required|string',
            'description_en' => 'required|string',
            'description_ru' => 'required|string',
        ]);

        $data = [
            'phone' => $request->phone,
            'email' => $request->email,
            'country_id' => $request->country_id,
            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
        ];

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image');
            $imageName =  time().'_'.$imagePath->getClientOriginalName();
            $request->file('image')->storeAs('uploads/constructor_agencies', $imageName, 'public');
            $data['image'] = $imageName;
        }



        foreach (config('translatable.locales') as $locale){
            $data[$locale] = [
                    'name' => $request->{'name_'.$locale},
                    'description' => $request->{'description_'.$locale}
                ];
        }

        $constructor_agency = ConstAgency::findOrFail($id);
        $constructor_agency->update($data);

        toastr()->success("Constructor Agency Updated!");

        return redirect('/admin/constructor_agencies');
    }

    public function removeImage(Request $request)
    {
        if (ConstAgency::where('id', $request->id)->update(['image' => null])){
            Storage::disk('public')->delete('uploads/constructor_agencies/'.$request->image);
            return response()->json([
                'alert' => 'success',
                'message' => 'Deleted!',
            ]);
        }else{
            return response()->json([
                'alert' => 'error',
                'message' => 'Something went wrong please try again!',
            ]);
        }
    }

    public function destroy($id){
        $constructor_agency = ConstAgency::findOrFail($id);
        Storage::disk('public')->delete('uploads/constructor_agencies/'.$constructor_agency->image);
        $constructor_agency->delete();
        toastr()->success("Constructor Agency deleted!");

        return redirect('/admin/constructor_agencies');
    }
}
