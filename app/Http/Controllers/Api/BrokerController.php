<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Role;
use App\User;
use Illuminate\Http\Request;

class BrokerController extends Controller
{
    public function index()
    {
        $brokers = User::whereHas(
            'roles', function ($q) {
            $q->where('slug', 'broker');
        }
        )->paginate(6);
        return response()->json(compact('brokers'));
    }
    public function getNames()
    {
        $brokers = Role::where('slug','broker')->first()->users('first_name', 'last_name')->get();
        return response()->json(compact('brokers'));
    }
    public function getSuperBrokerNames()
    {
        $brokers = Role::where('slug','super_broker')->first()->users()->get();
        return response()->json(compact('brokers'));
    }
    public function superBrokers()
    {
        $brokers = User::whereHas(
            'roles', function ($q) {
            $q->where('slug', 'super_broker');
        }
        )->paginate(6);
        return response()->json(compact('brokers'));
    }
    public function brokersList()
    {
        $brokersAll = User::whereHas(
            'roles', function ($q) {
            $q->where('name', 'Broker');
        }
        )->with('agency', 'country', 'state', 'city')->get();

        $brokers = [];
        foreach ($brokersAll as $broker) {
            $broker['rating'] = (int)$broker->averageRating;
            if ($broker['rating'] > 3) {
                array_push($brokers, $broker);
            }
        }
        return response()->json(compact('brokers'));
    }

    public function broker(Request $request)
    {
        $broker = User::query()->where('id', (int)$request->id)->
        with('super_broker', 'country', 'state', 'city','broker_comments.user','brokerAnnouncements','brokerAnnouncements.category','brokerAnnouncements.currency')->first();
        $broker['rating'] = (int)$broker->averageRating;
        return response()->json(compact('broker'));
    }

    public function search(Request $request)
    {
        $full_name = explode(" ",$request->input('data.name'));
        $first_name = $full_name[0];
        $arr = [];
        if(count($full_name)>1){
            $last_name = $full_name[1];
        $data = [
            ['first_name', '=', $first_name],
            ['last_name', '=', $last_name],
            ['agency_id', '=', (int)$request->input('data.agency')],
            ['city_id', '=', (int)$request->input('data.region')],
            ['broker_type', '=', $request->input('data.service_type')],
        ];
        }else{
            $data = [
                ['first_name', '=', $first_name],
                ['agency_id', '=', (int)$request->input('data.agency')],
                ['city_id', '=', (int)$request->input('data.region')],
                ['broker_type', '=', $request->input('data.service_type')],
            ];
        }
        foreach ($data as $value) {
            if ($value[2]) {
                array_push($arr, $value);
            }
        }
        $brokers = User::whereHas(
            'roles', function ($q) {
            $q->where('name', 'Broker');
        })->where($arr)->with('super_broker', 'country', 'state', 'city')->paginate(8);
        foreach ($brokers as $broker) {
            $broker['rating'] = (int)$broker->averageRating;
        }
        return response()->json(compact('brokers','full_name'));
    }

}

