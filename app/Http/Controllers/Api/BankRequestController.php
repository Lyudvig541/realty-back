<?php

namespace App\Http\Controllers\Api;

use App\BankRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;



class BankRequestController extends Controller
{

    public function index(){

    }

    public function create(Request $request)
    {

        $file = $request->input('data.file');
        $folderPath = "uploads/bankRequestFiles/";
        $url_parts_file = explode(";base64,", $file[0]['data_url']);
        $type_aux_file = explode("image/", $url_parts_file[0]);
        $type_file = $type_aux_file[1];
        $file_uniq_path = uniqid() . '.'.$type_file;
        Storage::disk('public')->put($folderPath . $file_uniq_path, base64_decode($url_parts_file[1]));
        $filePath = $file_uniq_path;

        $data = [
            'property_price' =>(int)$request->input('data.property_price'),
            'user_id'=>(int)$request->input('data.user_id'),
            'company_id'=>(int)$request->input('data.company_id'),
            'property_size' => (int)$request->input('data.property_size'),
            'bedrooms' =>(int)$request->input('data.bedrooms'),
            'bathrooms' => (int)$request->input('data.bathrooms'),
            'comment' => $request->input('data.comment'),
            'file' =>$filePath,

        ];

        $bankRequest = BankRequest::create($data);

        return response()->json(compact('bankRequest'));
    }
}

