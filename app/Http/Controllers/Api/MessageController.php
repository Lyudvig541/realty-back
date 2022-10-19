<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $messages = Message::where('user_id',$request->user_id)->with('broker')->orderBy('broker_id', 'asc')->orderBY('created_at','desc')->get();
        return response()->json(compact('messages'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function userBrokerMessages(Request $request)
    {
        $messages = Message::where('user_id',$request->user_id)->where('broker_id',$request->broker_id)->with('broker')->orderBY('created_at','desc')->paginate(8);
        Message::where([['user_id', $request->user_id],['broker_id', $request->broker_id],['user_status',1]])->update(['user_status' => '0']);
        return response()->json(compact('messages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Message::create([
            'user_id'=>$request->user_id,
            'broker_id'=>$request->agent_id,
            'message'=>$request->message,
            'broker_status'=>'1',
            'user_status'=>'0',
        ]);
        return response()->json(['status'=>200,'message'=>'success']);
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
    /**
    * Get count of unread messages
     * @param int $user_id
     * @return \Illuminate\Http\Response
    */
    public function unreadMessages(Request $request){
        $unreadMessages = Message::where('user_id',$request->user_id)->where('user_status',1)->groupBy('broker_id')->get();
        return response()->json(compact('unreadMessages'));
    }
}
