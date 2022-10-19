<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Page;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class PageController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = Page::paginate(10);
        return view('admin.page.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $pages = Page::all();
        $languages = config('translatable.locales');
        return view('admin.page.create_page', compact('pages', 'languages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

        public function store(Request $request)
    {
        $request->validate([
            'title_am' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'title_ru' => 'required|string|max:255',
            'sub_title_am' => 'required|string|max:255',
            'sub_title_en' => 'required|string|max:255',
            'sub_title_ru' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'image' => 'mimes:png,jpg,jpeg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image');
            $imageName =  time().'_'.$imagePath->getClientOriginalName();
            $request->file('image')->storeAs('uploads/pages', $imageName, 'public');
        }else{
            $imageName = null;
        }

        $data = [
            'image' => $imageName,
            'slug' => $request->slug,
        ];


        foreach (config('translatable.locales') as $locale){
            $data[$locale] = [
                'title' => $request->{'title_'.$locale},
                'sub_title' => $request->{'sub_title_'.$locale},
                'editor' => $request->{'editor_'.$locale}
            ];
        }

        Page::create($data);

        toastr()->success("Page saved!");

        return redirect('/admin/pages');
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page = Page::find($id);
        $languages = config('translatable.locales');
        return view('admin.page.edit_page', compact('page', 'languages'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){

        $data = [];
        $request->validate([
            'title_am' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'title_ru' => 'required|string|max:255',
            'sub_title_am' => 'required|string|max:255',
            'sub_title_en' => 'required|string|max:255',
            'sub_title_ru' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
        ]);
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image');
            $imageName = time().'_'.$imagePath->getClientOriginalName();
            $request->file('image')->storeAs('uploads/pages', $imageName, 'public');
            $data['image'] = $imageName;
        }

        $data = [
            'slug' => $request->slug,
        ];

        foreach (config('translatable.locales') as $locale) {
            $data[$locale] = [
                'title' => $request->{'title_'.$locale},
                'sub_title' => $request->{'sub_title_'.$locale},
                'editor' => $request->{'editor_'.$locale}
            ];
        }

        $page = Page::findOrFail($id);
        $page->update($data);

        toastr()->success("Page Updated!");

        return redirect('/admin/pages');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $page = Page::findOrFail($id);
        Storage::disk('public')->delete('uploads/pages/'.$page->image);
        $page->delete();
        toastr()->success("page deleted!");

        return redirect('/admin/pages');
    }
    public function removeImage(Request $request)
    {

        if (Page::where('id', $request->id)->update(['image' => null])){
            Storage::disk('public')->delete('uploads/pages/'.$request->image);
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
