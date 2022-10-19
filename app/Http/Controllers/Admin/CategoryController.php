<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Type;
use Illuminate\Http\Request;
use App\Category;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{

    public function index(){
        $categories = Category::paginate(10);
        return view('admin.category.index', compact('categories'));
    }

    public function create(){
        $categories = Category::all();
        $languages = config('translatable.locales');
        return view('admin.category.create_category', compact('categories', 'languages'));
    }

    public function store(Request $request){

        $request->validate([
            'name_am' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'name_ru' => 'required|string|max:255',
            'image' => 'mimes:jpeg,png|max:1014',
        ]);
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image');
            $imageName =  time().'_'.$imagePath->getClientOriginalName();
            $request->file('image')->storeAs('uploads/categories', $imageName, 'public');
        }else{
            $imageName = null;
        }
        $data = [
            'image' => $imageName,
        ];

        foreach (config('translatable.locales') as $locale){
            $data[$locale] = ['name' => $request->{'name_'.$locale}];
        }

        Category::create($data);

        toastr()->success("Category saved!");

        return redirect('/admin/categories');
    }


    public function edit($id){
        $category = Category::find($id);
        $categories = Category::get();
        $languages = config('translatable.locales');
        return view('admin.category.edit_category', compact('category', 'categories', 'languages'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name_am' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'name_ru' => 'required|string|max:255',
            'image' => 'mimes:jpeg,png|max:1014',
        ]);
        $data =[];
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image');
            $imageName =  time().'_'.$imagePath->getClientOriginalName();
            $request->file('image')->storeAs('uploads/categories', $imageName, 'public');
            $data = [
                'image' => $imageName,
            ];
        }
        foreach (config('translatable.locales') as $locale){
            $data[$locale] = ['name' => $request->{'name_'.$locale}];
        }
        $category = Category::findOrFail($id);
        $category->update($data);

        toastr()->success("Category Updated!");

        return redirect('/admin/categories');
    }
    public function removeImage(Request $request){

        if (Category::where('id', $request->id)->update(['image' => null])){
            Storage::disk('public')->delete('uploads/categories/'.$request->image);
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
        $category = Category::find($id);
        Storage::disk('public')->delete('uploads/categories/'.$category->image);
        $category->delete();
        toastr()->success("Category deleted!");

        return redirect('/admin/categories');
    }
}
