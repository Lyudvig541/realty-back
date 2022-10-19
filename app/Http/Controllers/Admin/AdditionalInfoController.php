<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\AdditionalInfo;
use Illuminate\Support\Facades\Storage;


class AdditionalInfoController extends Controller
{

    public function index(){
        $additional_infos = AdditionalInfo::paginate(10);
        return view('admin.additional_info.index', compact('additional_infos'));
    }

    public function create(){
        $languages = config('translatable.locales');
        return view('admin.additional_info.create', compact('languages'));
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
            $request->file('image')->storeAs('uploads/additional_infos', $imageName, 'public');
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

        AdditionalInfo::create($data);

        toastr()->success("Additional Info saved!");

        return redirect('/admin/additional_infos');
    }


    public function edit($id){
        $additional_info = AdditionalInfo::find($id);
        $languages = config('translatable.locales');
        return view('admin.additional_info.edit', compact('additional_info', 'languages'));
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
            $request->file('image')->storeAs('uploads/additional_infos', $imageName, 'public');
            $data['image'] = $imageName;
        }


        foreach (config('translatable.locales') as $locale){
            $data[$locale] = [
                'title' => $request->{'title_'.$locale}
            ];
        }

        $additional_info = AdditionalInfo::findOrFail($id);
        $additional_info->update($data);

        toastr()->success("Additional Info Updated!");

        return redirect('/admin/additional_infos');
    }

    public function destroy($id){
        $additionalInfo = AdditionalInfo::findOrFail($id);
        Storage::disk('public')->delete('uploads/additional_infos/'.$additionalInfo->image);
        $additionalInfo->delete();
        toastr()->success("Additional Info deleted!");

        return redirect('/admin/additional_infos');
    }

    public function removeImage(Request $request)
    {
        if (AdditionalInfo::where('id', $request->id)->update(['image' => null])){
            Storage::disk('public')->delete('uploads/additional_infos/'.$request->image);
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
