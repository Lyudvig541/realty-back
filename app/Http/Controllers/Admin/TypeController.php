<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TypeController extends Controller
{

    public function index()
    {
        $types = Type::paginate(10);
        return view('admin.type.index', compact('types'));
    }


    public function create()
    {
        $types = Type::all();
        $languages = config('translatable.locales');
        return view('admin.type.create_type', compact('types', 'languages'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name_am' => 'required|string',
            'name_en' => 'required|string',
            'name_ru' => 'required|string',
            'slug' => 'required|string',
            'image' => 'mimes:jpeg,png,jpg|max:1014',
        ]);
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image');
            $imageName =  time().'_'.$imagePath->getClientOriginalName();
            $request->file('image')->storeAs('uploads/announcement_types', $imageName, 'public');
        }else{
            $imageName = null;
        }
        $data = [
            'image'=>$imageName,
            'slug'=>$request->slug
        ];

        foreach (config('translatable.locales') as $locale){
            $data[$locale] = ['name' => $request->{'name_'.$locale}];
        }

        Type::create($data);

        toastr()->success("Type saved!");

        return redirect('/admin/types');

    }


    public function edit($id )
    {
        $type = Type::find($id);
        $languages = config('translatable.locales');
        return view('admin.type.edit_type', compact('type', 'languages'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name_am' => 'required|string',
            'name_en' => 'required|string',
            'name_ru' => 'required|string',
            'slug' => 'required|string',
            'image' => 'mimes:jpeg,png,jpg|max:1014',
        ]);
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image');
            $imageName =  time().'_'.$imagePath->getClientOriginalName();
            $request->file('image')->storeAs('uploads/announcement_types', $imageName, 'public');
            $data['image'] = $imageName;

        }
        $data['slug'] = $request->slug;

        foreach (config('translatable.locales') as $locale){
            $data[$locale] = ['name' => $request->{'name_'.$locale}];
        }

        $type = Type::findOrFail($id);
        $type->update($data);

        toastr()->success("Type updated!");

        return redirect('/admin/types');
    }
    public function removeImage(Request $request)
    {
        if (Type::where('id', $request->id)->update(['image' => null])){
            Storage::disk('public')->delete('uploads/announcement_types/'.$request->image);
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
        $type = Type::find($id);
        Storage::disk('public')->delete('uploads/announcement_types/'.$type->image);
        $type->delete();

        toastr()->success("Type deleted!");

        return redirect('/admin/types')->with('success','Type deleted!');
    }
}
