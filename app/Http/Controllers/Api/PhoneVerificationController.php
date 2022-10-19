<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class PhoneVerificationController extends Controller
{

    public function getCode(Request $request)
    {
        if ($request->id) {
            $validatorHouse = Validator::make($request->all(), [
                'phone' => ['required', 'unique:users,phone,' . $request->id],
            ], [
                'phone.required' => "phone_required",
                'phone.unique' => "phone_unique",
            ]);
        } else {
            $validatorHouse = Validator::make($request->all(), [
                'phone' => ['required', 'unique:users'],
            ], [
                'phone.required' => "phone_required",
                'phone.unique' => "phone_unique",

            ]);
        }

        if ($validatorHouse->fails()) {
            return response()->json([
                'errors' => $validatorHouse->messages(),
                'status' => 400
            ]);
        }
        $code = random_int(100000, 999999);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_USERPWD, '1sqrealty' . ":" . 'PHt47SQ3');
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://45.131.124.7/broker-api/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{"messages":[{"recipient":"' . $request->phone . '","priority":"2","sms":{"originator":"1SQ.realty","content":{"text":"' . $code . '"}},"message-id":"201902280917"}]}',
            CURLOPT_HTTPHEADER => array(
                'Content-type: application/json; charset=utf-8'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        if ($response === "OK") {
            User::where('id', $request->id)->update([
                "phone" => $request->phone,
                "phone_number_verify_code" => $code,
            ]);
            return response()->json([
                'code_success' => $response,
                'status' => 200
            ]);
        }
    }

    public function checkCode(Request $request)
    {
        $validatorHouse = Validator::make($request->all(), [
            'phone' => ['required', 'unique:users,phone,' . $request->id],
            'code' => 'required',
        ], [
            'phone.required' => "phone_required"
        ]);
        if ($validatorHouse->fails()) {
            return response()->json([
                'errors' => $validatorHouse->messages(),
                'status' => 400
            ]);
        }
        $verified = User::where('id', $request->id)
            ->where('phone', $request->phone)
            ->where('phone_number_verify_code', $request->code)
            ->update([
                "phone_number_verified_at" => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
        if ($verified) {
            return response()->json([
                'status' => 200,
            ]);
        } else {
            return response()->json([
                'errors' => ['code' => ['Verification code not valid']],
                'status' => 400
            ]);
        }
    }
}

