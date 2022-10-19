<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Page;
use Illuminate\Http\Request;

class TextPageController extends Controller
{

    public function pages(Request $request)
    {
        $pages = Page::all();
        return response()->json(compact('pages'));
    }

    public function page(Request $request)
    {
        $page = Page::query()->where('slug',$request->slug)->first();
        return response()->json(compact('page'));
    }


}
