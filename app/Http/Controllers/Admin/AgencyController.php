<?php

namespace App\Http\Controllers\Admin;

use App\City;
use App\Country;
use App\Http\Controllers\Controller;
use App\Agency;
use App\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AgencyController extends Controller
{

    public function index(){
        $agencies = Agency::paginate(10);
        return view('admin.agency.index', compact('agencies'));
    }

    public function create(){
        $agencies = Agency::all();
        $countries = Country::get();
        $states = State::get();
        $languages = config('translatable.locales');
        return view('admin.agency.create', compact('agencies', 'languages', 'countries', 'states'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_am' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'name_ru' => 'required|string|max:255',
            'phone' => 'required|max:20|min:6|unique:agencies',
            'description_am' => 'required|string|max:5000',
            'description_en' => 'required|string|max:5000',
            'description_ru' => 'required|string|max:5000',
            'image' => 'mimes:png,jpg,jpeg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image');
            $imageName =  time().'_'.$imagePath->getClientOriginalName();
            $request->file('image')->storeAs('uploads/agencies', $imageName, 'public');
        }else{
            $imageName = null;
        }

        $data = [
            'image' => $imageName,
            'phone' => $request->phone,
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

        Agency::create($data);

        toastr()->success("Agency saved!");

        return redirect('/admin/agencies');
    }


    public function edit($id){
        $agency = Agency::find($id);
        $countries = Country::get();
        $states = State::get();
        $cities = City::where('state_id', $agency->state_id)->get();
        $languages = config('translatable.locales');
        return view('admin.agency.edit', compact('agency', 'languages', 'countries', 'states', 'cities'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'name_am' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'name_ru' => 'required|string|max:255',
            'phone' => 'required|max:20|min:6|unique:agencies,phone,'.$id,
            'description_am' => 'required|string|max:5000',
            'description_en' => 'required|string|max:5000',
            'description_ru' => 'required|string|max:5000',
        ]);
        $data = [
            'phone' => $request->phone,
            'country_id' => $request->country_id,
            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
        ];
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image');
            $imageName =  time().'_'.$imagePath->getClientOriginalName();
            $request->file('image')->storeAs('uploads/agencies', $imageName, 'public');
            $data['image'] = $imageName;
        }
        foreach (config('translatable.locales') as $locale){
            $data[$locale] = [
                    'name' => $request->{'name_'.$locale},
                    'description' => $request->{'description_'.$locale}
                ];
        }
        $agency = Agency::findOrFail($id);
        $agency->update($data);

        toastr()->success("Agency Updated!");

        return redirect('/admin/agencies');
    }

    public function removeImage(Request $request)
    {
        if (Agency::where('id', $request->id)->update(['image' => null])){
            Storage::disk('public')->delete('uploads/agencies/'.$request->image);
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
        $agency = Agency::findOrFail($id);
        Storage::disk('public')->delete('uploads/agencies/'.$agency->image);
        $agency->delete();
        toastr()->success("Agency deleted!");

        return redirect('/admin/agencies');
    }
}
