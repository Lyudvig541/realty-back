<?php
namespace App\Http\Controllers\Admin;

use App\AgentRequest;
use App\Http\Controllers\Controller;

class AgentRequestController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $requests = AgentRequest::paginate(10);
        return view('admin.agent_request.index', compact('requests'));
    }
}
