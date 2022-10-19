<?php

namespace App\Http\Controllers\Admin;


use App\BankRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;


class BankRequestController extends Controller
{

    public function index()
    {
        $bank_requests = BankRequest::with('user', 'company')->paginate(10);
        return view('admin.bank_request.index', compact('bank_requests'));
    }


    public function destroy($id)
    {
        if ($bank_request = BankRequest::findOrFail($id)) {
            Storage::disk('public')->delete('uploads/bankRequestFiles/'.$bank_request->file);
            $bank_request->delete();
            toastr()->success("Request deleted!");
            return redirect('/admin/bank_requests');
        } else {
            toastr()->error("Sum ting went wrong!");
        }
    }
}

