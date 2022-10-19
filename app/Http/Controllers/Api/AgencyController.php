<?php

namespace App\Http\Controllers\Api;

use App\Announcement;
use App\Http\Controllers\Controller;
use App\Agency;
use App\Role;
use App\User;
use Illuminate\Http\Request;


class AgencyController extends Controller
{

    public function index(){
        $agencies = Role::where('slug', 'super_broker')->first()->users()->get();
        return response()->json(compact('agencies'));
    }
    public function agencies(){
        $agencies = Role::where('slug', 'super_broker')->first()->users()->paginate(6);
        return response()->json(compact('agencies'));
    }
    public function topAgencies(){
        $top_agencies = Role::where('slug','super_broker')->first()->users()->offset(0)->limit(10)->get();
        return response()->json(compact('top_agencies'));
    }
    public function agency(Request $request)
    {
        $agency = User::where('id', (int)$request->id)->with( 'country', 'state', 'city','brokers')->first();
        return response()->json(compact('agency'));
    }
    public function agencyAnnoucements(Request $request)
    {
        $announcements = Announcement::where('user_id', (int)$request->id)->orWhere('broker_id', (int)$request->id)->with('category', 'currency')->get();
        return response()->json(compact('announcements'));
    }
    public function agencyBrokersAnnoucements(Request $request)
    {
        $announcements = User::where('id', (int)$request->id)->first()->brokersAnnouncements()->with('category', 'currency')->get();
        return response()->json(compact('announcements'));
    }
}

