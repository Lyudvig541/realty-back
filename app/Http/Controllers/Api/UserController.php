<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    public function update(Request $request)
    {
        if ($request->data['password'] || $request->data['old_password'] || $request->data['password_confirmation']) {
            $validator = Validator::make($request->all(), [
                'data.first_name' => 'required|string|max:255',
                'data.last_name' => 'required|string|max:255',
                'data.email' => 'required|string|email|max:255',
                'data.password' => ['required', 'min:8', 'confirmed'],
                'data.password_confirmation' => ['required'],
                'data.old_password' => ['required'],
            ], [
                'data.email.required' => 'email_required',
                'data.email.email' => 'wrong_email',
                'data.old_password.required'=>'password_require_error',
                'data.password_confirmation.required'=>'password_confirmation_require_error',
                'data.password.required'=>'new_password_required',
                'data.password.min'=>'password_min_error',
                'data.password.confirmed'=>'confirm_password_error',
            ]);
            $user = User::find($request->id);

            if (!Hash::check( $request->data['old_password'],$user->password)) {
              $validator->errors()->add( 'data.old_password','old_password_valid');
            }
            if ($validator->errors()->isNotEmpty()) {
                return response()->json(['status' => 400, 'message' => $validator->messages()]);
            }

            User::where('id', $request->id)->update([
                'first_name' => $request->data['first_name'],
                'last_name' => $request->data['last_name'],
                'email' => $request->data['email'],
                'password' => Hash::make($request->data['password']),
            ]);

        } else {
            $validator = Validator::make($request->all(), [
                'data.first_name' => 'required|string|max:255',
                'data.last_name' => 'required|string|max:255',
                'data.email' => 'required|string|email|max:255',
            ], [
                'data.email.required' => 'email_required',
                'data.email.email' => 'wrong_email',

            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 400, 'message' => $validator->messages()]);
            };

            User::where('id', $request->id)->update([
                'first_name' => $request->data['first_name'],
                'last_name' => $request->data['last_name'],
                'email' => $request->data['email'],
            ]);
        }

        $user = User::find($request->id);


        return response()->json(compact('user'));
    }

    public function edit_user_image(Request $request)
    {
        $avatar = $request->file;
        $image_parts_certif = explode(";base64,", $avatar[0]['data_url']);
        $image_type_aux_certif = explode("image/", $image_parts_certif[0]);
        $image_type_certif = $image_type_aux_certif[1];
        $avatarImage = base64_decode($image_parts_certif[1]);
        $file_certif = uniqid() . '.' . $image_type_certif;
        $img = Image::make($avatarImage);
        $img->resize(800, 800)->insert(public_path('logo.png'), 'bottom-right', 10, 10)->save(storage_path() . '/app/public/uploads/users/' . $file_certif);

        $avatarPath = $file_certif;
        if($user = User::where('id', $request->id)->first()){
            Storage::disk('public')->delete('uploads/users/' . $user->avatar);
        }
        $user->update(['avatar' => $avatarPath]);
        return response()->json(compact('user'));
    }


    public function user(Request $request)
    {
        $user = User::where('id', (int)$request->id)->first();
        return response()->json(compact('user'));
    }


}
