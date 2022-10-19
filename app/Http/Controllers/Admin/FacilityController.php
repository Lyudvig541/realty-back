<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Facility;
use Illuminate\Support\Facades\Storage;


class FacilityController extends Controller
{

    public function index(){
        $facilities = Facility::paginate(10);
        return view('admin.facility.index', compact('facilities'));
    }

    public function create(){
        $languages = config('translatable.locales');
        return view('admin.facility.create', compact('languages'));
    }

    public function store(Request $request){

        $request->validate([
            'title_am' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'title_ru' => 'required|string|max:255',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image');
            $imageName =  time().'_'.$imagePath->getClientOriginalName();
            $request->file('image')->storeAs('uploads/facilities', $imageName, 'public');
        }else{
            $imageName = null;
        }

        $data = [
            'image' => $imageName,
            'value' => $request->value,
        ];

        foreach (config('translatable.locales') as $locale){
            $data[$locale] = [
                'title' => $request->{'title_'.$locale}
            ];
        }

        Facility::create($data);

        toastr()->success("Facility saved!");

        return redirect('/admin/facilities');
    }


    public function edit($id){
        $facility = Facility::find($id);
        $languages = config('translatable.locales');
        return view('admin.facility.edit', compact('facility', 'languages'));
    }

    public function update(Request $request, $id){

        $request->validate([
            'title_am' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'title_ru' => 'required|string|max:255',
        ]);

        $data = [
            'value' => $request->value,
        ];
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image');
            $imageName =  time().'_'.$imagePath->getClientOriginalName();
            $request->file('image')->storeAs('uploads/facilities', $imageName, 'public');
            $data['image'] = $imageName;
        }


        foreach (config('translatable.locales') as $locale){
            $data[$locale] = [
                'title' => $request->{'title_'.$locale}
            ];
        }

        $facility = Facility::findOrFail($id);
        $facility->update($data);

        toastr()->success("Facility Updated!");

        return redirect('/admin/facilities');
    }

    public function destroy($id){
        $facility = Facility::findOrFail($id);
        Storage::disk('public')->delete('uploads/facilities/'.$facility->image);
        $facility->delete();
        toastr()->success("Facility deleted!");

        return redirect('/admin/facilities');
    }

    public function removeImage(Request $request)
    {
        if (Facility::where('id', $request->id)->update(['image' => null])){
            Storage::disk('public')->delete('uploads/facilities/'.$request->image);
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
}
