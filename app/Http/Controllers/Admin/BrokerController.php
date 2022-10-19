<?php

namespace App\Http\Controllers\Admin;

use App\Agency;
use App\City;
use App\Country;
use App\Http\Controllers\Controller;
use App\Role;
use App\State;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BrokerController extends Controller
{
    public function index(){
        $slug = null;
        if(auth()->user()->hasRole('super_broker')){
            $brokers = User::where('id', Auth::id())->first()->brokers()->paginate(10);
        }else{
            $brokers = User::whereHas('roles', function($q){$q->where('name', 'Broker');})->paginate(10);
        }
        return view('admin.broker.index', compact('brokers','slug'));
    }
    public function superBrokers(){

       $brokers = User::whereHas('roles', function($q){$q->where('slug', 'super_broker');})->paginate(10);
       $slug = "_super";
       return view('admin.broker.index', compact('brokers','slug'));
    }

    public function create(){
        $slug = null;
        $languages = config('translatable.locales');
        $countries = Country::get();
        $states = State::get();
        $agencies = Role::where('slug','super_broker')->first()->users()->get();
        return view('admin.broker.create_broker', compact('agencies', 'countries', 'states', 'slug','languages'));
    }
    public function createSuperBroker(){
        $languages = config('translatable.locales');
        $countries = Country::get();
        $states = State::get();
        $agencies = Role::where('slug','super_broker')->first()->users()->get();
        $slug = "_super";
        return view('admin.broker.create_broker', compact('agencies', 'countries', 'states','slug', 'languages'));
    }

    public function store(Request $request){

        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'string',
            'avatar' => 'mimes:jpeg,png|max:1014',
            'email'=>'required|string|email|max:255|unique:users',
            'phone' => 'required|max:20|min:6|unique:users',
            'rating' => 'required',
        ]);

        if ($request->hasFile('avatar')) {
            $imagePath = $request->file('avatar');
            $imageName =  time().'_'.$imagePath->getClientOriginalName();
            $request->file('avatar')->storeAs('uploads/users', $imageName, 'public');
        }else{
            $imageName = null;
        }

        $password = Str::random(8);

        $broker = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'avatar' => $imageName,
            'email' => $request->email,
            'password' => Hash::make($password),
            'phone' => $request->phone,
            'info' => $request->info,
            'broker_id' => $request->agency_id,
            'country_id' => $request->country_id,
            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
            'broker_licenses' => $request->broker_licenses,
            'broker_type' => $request->broker_type,
        ]);

        $broker->roles()->attach(4);

        if ($broker){
            $rating = new \willvincent\Rateable\Rating;
            $rating->rating = $request->rating;
            $rating->user_id = $broker->id;
            $broker->ratings()->save($rating);

            $details = [
                'title' => 'Mail from 1SQ.realty',
                'login' => 'Login : '. $request->email,
                'password' => 'Password : ' .$password,
            ];

            Mail::to($request->email)->send(new \App\Mail\Mail($details));

            toastr()->success("Broker saved!");


        }else{
            toastr()->error("Sum ting went wrong!");
        }
        return redirect('/admin/brokers');
    }
    public function storeSuperBroker(Request $request){
        $request->validate([
            'name_am' => ['required', 'string', 'max:255'],
            'name_en' => ['required', 'string', 'max:255'],
            'name_ru' => ['required', 'string', 'max:255'],
            'avatar' => 'mimes:jpeg,png|max:1014',
            'email'=>'required|string|email|max:255|unique:users',
            'phone' => 'required|max:20|min:6|unique:users',
            'rating' => 'required',
        ]);

        if ($request->hasFile('avatar')) {
            $imagePath = $request->file('avatar');
            $imageName =  time().'_'.$imagePath->getClientOriginalName();
            $request->file('avatar')->storeAs('uploads/users', $imageName, 'public');
        }else{
            $imageName = null;
        }

        $password = Str::random(8);
        $data = [
            'avatar' => $imageName,
            'email' => $request->email,
            'password' => Hash::make($password),
            'phone' => $request->phone,
            'info' => $request->info,
            'country_id' => $request->country_id,
            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
            'broker_licenses' => $request->broker_licenses,
        ];

        foreach (config('translatable.locales') as $locale) {
            if ($request->{'description_' . $locale}) {
                $data[$locale] = [
                    'description' => $request->{'description_' . $locale},
                    'name' => $request->{'name_' . $locale},
                ];
            }
        }
        $broker = User::create($data);
        $broker->roles()->attach(Role::where('slug','super_broker')->first()->id);

        if ($broker){
            $rating = new \willvincent\Rateable\Rating;
            $rating->rating = $request->rating;
            $rating->user_id = $broker->id;
            $broker->ratings()->save($rating);

            $details = [
                'title' => 'Mail from 1SQ.realty',
                'login' => 'Login : '. $request->email,
                'password' => 'Password : ' .$password,
            ];

            Mail::to($request->email)->send(new \App\Mail\Mail($details));

            toastr()->success("Broker saved!");


        }else{
            toastr()->error("Sum ting went wrong!");
        }
        return redirect('/admin/brokers');
    }
    public function edit($id){
        $slug = null;
        $languages = config('translatable.locales');
        $countries = Country::get();
        $states = State::get();
        $agencies = Role::where('slug','super_broker')->first()->users()->get();;
        $broker = User::query()->find($id);
        $cities = City::where('state_id', $broker->state_id)->get();
        return view('admin.broker.edit_broker', compact('broker','agencies', 'countries', 'states', 'cities','slug','languages'));
    }
    public function editSuperBroker($id){
        $languages = config('translatable.locales');
        $slug = '_super';
        $countries = Country::get();
        $states = State::get();
        $agencies = [];
        $broker = User::query()->find($id);
        $cities = City::where('state_id', $broker->state_id)->get();
        return view('admin.broker.edit_broker', compact('broker','agencies', 'countries', 'states', 'cities','slug', 'languages'));
    }
    public function update(Request $request, $id){
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'string',
            'avatar' => 'mimes:jpeg,png|max:1014',
            'email'=>'required|string|email|max:255|unique:users,email,'.$id,
            'phone' => 'required|max:20|min:6|unique:users,email,'.$id,
            'rating' => 'required',
        ]);

        $data = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'info' => $request->info,
            'broker_id' => $request->agency_id,
            'country_id' => $request->country_id,
            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
            'broker_licenses' => $request->broker_licenses,
            'broker_type' => $request->broker_type,
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
            $rating = new \willvincent\Rateable\Rating;
            $rating->rating = $request->rating;
            $rating->user_id = $broker->id;
            $broker->ratings()->save($rating);

            toastr()->success("Broker saved!");

        }else{
            toastr()->error("Sum ting went wrong!");
        }
        return redirect('/admin/brokers');
    }
    public function updateSuperBroker(Request $request, $id){
        $request->validate([
            'name_am' => ['required', 'string', 'max:255'],
            'name_en' => ['required', 'string', 'max:255'],
            'name_ru' => ['required', 'string', 'max:255'],
            'last_name' => 'string',
            'avatar' => 'mimes:jpeg,png|max:1014',
            'email'=>'required|string|email|max:255|unique:users,email,'.$id,
            'phone' => 'required|max:20|min:6|unique:users,email,'.$id,
            'rating' => 'required',
        ]);

        $data = [
            'email' => $request->email,
            'phone' => $request->phone,
            'info' => $request->info,
            'country_id' => $request->country_id,
            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
            'broker_licenses' => $request->broker_licenses,
        ];
        foreach (config('translatable.locales') as $locale) {
            if ($request->{'description_' . $locale}) {
                $data[$locale] = [
                    'description' => $request->{'description_' . $locale},
                    'name' => $request->{'name_' . $locale},
                ];
            }
        }
        if ($request->hasFile('avatar')) {
            $imagePath = $request->file('avatar');
            $imageName =  time().'_'.$imagePath->getClientOriginalName();
            $request->file('avatar')->storeAs('uploads/users', $imageName, 'public');
            $data['avatar'] = $imageName;
        }
        User::findOrFail($id)->update($data);
        $broker = User::findOrFail($id);
        if ($broker){
            $rating = new \willvincent\Rateable\Rating;
            $rating->rating = $request->rating;
            $rating->user_id = $broker->id;
            $broker->ratings()->save($rating);

            toastr()->success("Broker saved!");

        }else{
            toastr()->error("Sum ting went wrong!");
        }
        return redirect('/admin/brokers/super-brokers');
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

    public function destroy($id){
        if ($broker = User::findOrFail($id)){
            Storage::disk('public')->delete('uploads/users/'.$broker->avatar);
            $broker->ratings()->delete();
            $broker->delete();
            toastr()->success("Broker deleted!");
            return redirect('/admin/brokers');
        }else{
            toastr()->error("Sum ting went wrong!");
        }
    }
    public function destroySuperBroker($id){
        if ($broker = User::findOrFail($id)){
            Storage::disk('public')->delete('uploads/users/'.$broker->avatar);
            $broker->ratings()->delete();
            $broker->delete();
            toastr()->success("Broker deleted!");
            return redirect('/admin/brokers/super-brokers');
        }else{
            toastr()->error("Sum ting went wrong!");
        }
    }
}

