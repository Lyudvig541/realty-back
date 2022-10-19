<?php

namespace App\Http\Controllers\Api;

use App\Comment;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user_id = $request->user_id;
        $broker_id = $request->agent_id;
        $text = $request->message;
        if($request->rate_broker){
            $broker = User::where('id',$broker_id)->first();
            $rating = new \willvincent\Rateable\Rating;
            $rating->rating = $request->rate_broker;
            $rating->user_id = $broker_id;
            $broker->ratings()->save($rating);
        }
        Comment::create([
            'user_id'=>$user_id,
            'broker_id'=>$broker_id,
            'text'=>$text,
        ]);
        return response()->json(['status'=>200,'message'=>'success']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function userCommetns(Request $request)
    {
        $comments = Comment::where('user_id', $request->user_id)->get('broker_id');
        return response()->json(compact('comments'));
    }
}
