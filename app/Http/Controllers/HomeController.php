<?php

namespace App\Http\Controllers;

use App\Agency;
use App\Announcement;
use App\Message;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = 0;
        $brokers = 0;
        $announcements = 0;
        $agencies = 0;
        $users_by_month = [];
        $announcements_by_month = [];
        if(auth()->user()->hasRole('admin')){
            $users = Role::where('slug','user')->first()->users()->count();
            $brokers = Role::where('slug','broker')->first()->users()->count();
            $announcements = Announcement::query()->count();
            $agencies = Role::where('slug','super_broker')->first()->users()->count();
            for($i=0; $i < 12; $i++){
                $users_by_month[$i] = User::whereDate('created_at', '<=' ,date('Y-m-d',strtotime("-" . $i . " month")))->count();
                $announcements_by_month[$i] = Announcement::whereDate('created_at', '<=', date('Y-m-d',strtotime("-" . $i . " month")))->count();
            }
        }else{
            for($i=0; $i < 12; $i++){
                $users_by_month[$i] = 0;
                $announcements_by_month[$i] = 0;
            }
        }
        return view('admin.dashboard',compact('users','brokers','announcements','agencies', 'users_by_month', 'announcements_by_month'));
    }
}
