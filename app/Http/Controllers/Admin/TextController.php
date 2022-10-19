<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Text;
use Illuminate\Http\Request;

class TextController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $texts = Text::paginate(10);
        return view('admin.text.index', compact('texts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $languages = config('translatable.locales');
        return view('admin.text.create_text', compact( 'languages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
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
            'text_am' => 'required|string',
            'text_en' => 'required|string',
            'text_ru' => 'required|string',
            'slug' => 'required',
        ]);
        $data = [
            'slug' => $request->slug,
        ];
        foreach (config('translatable.locales') as $locale){
            $data[$locale] = [
                'title' => $request->{'title_'.$locale},
                'sub_title' => $request->{'sub_title_'.$locale},
                'text' => $request->{'text_'.$locale}
            ];
        }

        Text::create($data);
        toastr()->success("Text saved!");

        return redirect('/admin/texts');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $text = Text::find($id);
        $languages = config('translatable.locales');
        return view('admin.text.edit_text', compact('text', 'languages'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title_am' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'title_ru' => 'required|string|max:255',
            'sub_title_am' => 'required|string|max:255',
            'sub_title_en' => 'required|string|max:255',
            'sub_title_ru' => 'required|string|max:255',
            'text_am' => 'required|string',
            'text_en' => 'required|string',
            'text_ru' => 'required|string',
        ]);
        $text = Text::find($id);
        foreach (config('translatable.locales') as $locale) {
            $data[$locale] = [
                'title' => $request->{'title_'.$locale},
                'sub_title' => $request->{'sub_title_'.$locale},
                'text' => $request->{'text_'.$locale}
            ];
        }
        $text->update($data);
        toastr()->success("Text Updated!");

        return redirect('/admin/texts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $text = Text::findOrFail($id);
        $text->delete();
        toastr()->success("text deleted!");

        return redirect('/admin/texts');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function text(Request $request){
        $text = Text::where('slug',$request->slug)->first();
        return response()->json(compact('text'));
    }
}
