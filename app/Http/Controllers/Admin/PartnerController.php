<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PartnerController extends Controller
{

    public function index(){
        $partners = Partner::paginate(10);
        return view('admin.partner.index', compact('partners'));
    }

    public function create(){
        $partners = Partner::all();
        $languages = config('translatable.locales');
        return view('admin.partner.create', compact('partners', 'languages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_am' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'name_ru' => 'required|string|max:255',
            'description_am' => 'required|string|max:255',
            'description_en' => 'required|string|max:255',
            'description_ru' => 'required|string|max:255',
            'image' => 'mimes:png,jpg,jpeg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image');
            $imageName =  time().'_'.$imagePath->getClientOriginalName();
            $request->file('image')->storeAs('uploads/partners', $imageName, 'public');
        }else{
            $imageName = null;
        }

        $data = [
            'image' => $imageName,
        ];


        foreach (config('translatable.locales') as $locale){
            $data[$locale] = [
                'name' => $request->{'name_'.$locale},
                'description' => $request->{'description_'.$locale}
            ];
        }

        Partner::create($data);

        toastr()->success("Partner saved!");

        return redirect('/admin/partners');
    }


    public function edit($id){
        $partner = Partner::find($id);
        $languages = config('translatable.locales');
        return view('admin.partner.edit', compact('partner', 'languages'));
    }

    public function update(Request $request, $id){
        $data = [];
        $request->validate([
            'name_am' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'name_ru' => 'required|string|max:255',
            'description_am' => 'required|string|max:255',
            'description_en' => 'required|string|max:255',
            'description_ru' => 'required|string|max:255',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image');
            $imageName =  time().'_'.$imagePath->getClientOriginalName();
            $request->file('image')->storeAs('uploads/partners', $imageName, 'public');
            $data['image'] = $imageName;
        }

        foreach (config('translatable.locales') as $locale){
            $data[$locale] = [
                    'name' => $request->{'name_'.$locale},
                    'description' => $request->{'description_'.$locale}
                ];
        }

        $partner = Partner::findOrFail($id);
        $partner->update($data);

        toastr()->success("Partner Updated!");

        return redirect('/admin/partners');
    }

    public function removeImage(Request $request)
    {

        if (Partner::where('id', $request->id)->update(['image' => null])){
            Storage::disk('public')->delete('uploads/partners/'.$request->image);
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

    public function destroy($id)
    {
        $partner = Partner::findOrFail($id);
        Storage::disk('public')->delete('uploads/partners/'.$partner->image);
        $partner->delete();

        toastr()->success("Partner deleted!");

        return redirect('/admin/partners');
    }
}
