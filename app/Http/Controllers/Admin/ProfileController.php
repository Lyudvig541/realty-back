<?php

namespace App\Http\Controllers\Admin;

use App\Agency;
use App\City;
use App\Country;
use App\Http\Controllers\Controller;
use App\Rules\MatchOldPassword;
use App\State;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{

    public function index(){
        $user = User::find(auth()->user()->id);
        $countries = Country::get();
        $states = State::get();
        $cities = City::where('state_id', $user->state_id)->get();
        return view('admin.profile.index', compact('user', 'countries', 'states', 'cities'));
    }

    public function edit(Request $request){
        $user = User::find($request->id);
        $countries = Country::get();
        $states = State::get();
        $cities = City::where('state_id', $user->state_id)->get();
        return view('admin.profile.edit', compact('user', 'countries', 'states', 'cities'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'string',
            'avatar' => 'mimes:jpeg,png|max:1014',
            'email'=>'required|string|email|max:255|unique:users,email,'.$id,
            'phone' => 'required|max:20|min:6|unique:users,email,'.$id,
        ]);

        $data = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'country_id' => $request->country_id,
            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
        ];

        if ($request->hasFile('avatar')) {
            $imagePath = $request->file('avatar');
            $imageName =  time().'_'.$imagePath->getClientOriginalName();
            $request->file('avatar')->storeAs('uploads/users', $imageName, 'public');
            $data['avatar'] = $imageName;
        }


        User::where('id', $id)->update($data);
        $broker = User::findOrFail($id);
        if ($broker){
            toastr()->success("Broker saved!");

        }else{
            toastr()->error("Sum ting went wrong!");
        }
        return redirect('/admin/profile');
    }

    public function change_password(){
        return view('auth.passwords.change_password');
    }


    public function update_password(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);

        toastr()->success("Password change successfully!");

        return redirect('/admin/change-password');
    }

    public function removeImage(Request $request){

        if (User::where('id', $request->id)->update(['avatar' => null])){
            Storage::disk('public')->delete('uploads/users/'.$request->avatar);
            return response()->json([
                'alert' => 'success',
                'message' => 'Deleted!',
            ]);
        }else{
            return response()->json([
                'alert' => 'error',
                'message' => 'Something went wrong please try again!',
            ]);
        }
    }
}
