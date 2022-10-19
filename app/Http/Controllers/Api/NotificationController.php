<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Notification;
use App\NotificationTranslation;
use Illuminate\Http\Request;


class NotificationController extends Controller
{

    public function index(){
        $notifications = Notification::where('user_id', auth('api')->user()->id)->where('status', "0")->get();
        return response()->json(compact('notifications'));
    }

    public function notifications(){
        $allNotifications = Notification::query()->where('user_id', auth('api')->user()->id)->orderBy('created_at',"desc")->paginate(6);
        return response()->json( compact('allNotifications'));
    }

    public function notification(Request $request)
    {
        $notification = Notification::query()->where('id', (int)$request->id)->first();
        return response()->json(compact('notification'));
    }

    public function readNotification($id)
    {
        $notification = Notification::findOrFail($id);
        if ($notification){
            $notification->update(['status' => 1]);
            $unreadNotification = Notification::where('user_id',$notification->user_id)->where('status',"0")->get();
            return response()->json(['status' => 200, 'unreadNotification' => $unreadNotification]);
        }
    }
    public function readAllNotification()
    {
        Notification::where('user_id', auth('api')->user()->id)->where("status","0")->update(['status' => 1]);
        $unreadNotification = Notification::where('user_id', auth('api')->user()->id)->orderBy('created_at',"desc")->paginate(6);;
        return response()->json(['status' => 200, 'unreadNotification' => $unreadNotification]);
    }

    public function createNotification(Request $request)
    {
        $notification = [
            'user_id' => $request->user_id,
            "type" => "primary",
            "status" => '0',
        ];
        $notification['en'] = [
            'text' => $request->data,
            "title" => "Contact Agent Message"
        ];
        $notification['ru'] = [
            'text' => $request->data,
            "title" => "Contact Agent Message"
        ];
        $notification['am'] = [
            'text' => $request->data,
            "title" => "Contact Agent Message"
        ];

        Notification::create($notification);


        return response()->json($request->user_id);

    }
}

