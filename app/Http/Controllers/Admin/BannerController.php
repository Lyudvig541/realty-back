<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Banner;

class BannerController extends Controller
{

    public function index(){
        $banners = Banner::paginate(10);
        return view('admin.banner.index', compact('banners'));
    }

    public function create(){
        $banners = Banner::all();
        $languages = config('translatable.locales');
        return view('admin.banner.create', compact('banners', 'languages'));
    }

    public function store(Request $request){

        $request->validate([
            'title_am' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'title_ru' => 'required|string|max:255',
            'description_am' => 'required|string|max:255',
            'description_en' => 'required|string|max:255',
            'description_ru' => 'required|string|max:255',
            'main_image' => 'mimes:png,jpg,jpeg|max:2048',
        ]);

        if ($request->hasFile('main_image')) {
            $imagePath = $request->file('main_image');
            $imageName =  time().'_'.$imagePath->getClientOriginalName();
            $request->file('main_image')->storeAs('uploads/banners', $imageName, 'public');
        }else{
            $imageName = 'default.png';
        }

        $data = [
            'main_image' => $imageName,
        ];

        foreach (config('translatable.locales') as $locale){
            $data[$locale] = [
                'title' => $request->{'title_'.$locale},
                'description' => $request->{'description_'.$locale}
            ];
        }

        Banner::create($data);

        toastr()->success("Banner saved!");

        return redirect('/admin/banners');
    }


    public function edit($id){
        $banner = Banner::find($id);
        $languages = config('translatable.locales');
        return view('admin.banner.edit', compact('banner', 'languages'));
    }

    public function update(Request $request, $id){

        $request->validate([
            'title_am' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'title_ru' => 'required|string|max:255',
            'description_am' => 'required|string|max:255',
            'description_en' => 'required|string|max:255',
            'description_ru' => 'required|string|max:255',
            'main_image' => 'mimes:png,jpg,jpeg|max:2048',
        ]);

        if ($request->hasFile('main_image')) {
            $imagePath = $request->file('main_image');
            $imageName =  time().'_'.$imagePath->getClientOriginalName();
            $request->file('main_image')->storeAs('uploads/banners', $imageName, 'public');
        }else{
            $imageName = $request->old_image;
        }

        $data = [
            'main_image' => $imageName,
        ];

        foreach (config('translatable.locales') as $locale){
            $data[$locale] = [
                'title' => $request->{'title_'.$locale},
                'description' => $request->{'description_'.$locale}
            ];
        }

        $banner = Banner::findOrFail($id);
        $banner->update($data);

        toastr()->success("Banner Updated!");

        return redirect('/admin/banners');
    }


    public function destroy($id){
        Banner::where('id', $id)->delete();

        toastr()->success("Banner deleted!");

        return redirect('/admin/banners');
    }
}
