<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends Controller
{

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    public function index(){
        $users = User::paginate(10);
        $languages = config('translatable.locales');
        return view('admin.user.index', compact('users','languages'));
    }

    public function create(){
        $roles = Role::all();
        return view('admin.user.create_user', compact('roles'));
    }

    public function store(Request $request){

        $password = Str::random(8);

        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'limit' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'max:255', 'unique:users'],
        ]);

        $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'announcements_limit' => $request->limit,
                'phone' => $request->phone,
                'password' => Hash::make($password)
        ]);

        $details = [
            'title' => 'Mail from 1SQ.realty',
            'login' => 'Login : '. $request->email,
            'password' => 'Password : ' .$password,
        ];

        Mail::to($request->email)->send(new \App\Mail\Mail($details));

        $user->roles()->attach($request->role);
        toastr()->success('User created');
        return redirect('/admin/users');

    }


    public function edit($id){
        $user = User::find($id);
        $roles = Role::orderBy('id', 'DESC')->get();
        return view('admin.user.edit_user',compact('user','roles'));
    }


    public function update(Request $request, $id){
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'limit' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$id],
            'phone' => ['required', 'unique:users,phone,'.$id],
        ]);

        $user = User::where('id', $id)->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'announcements_limit' => $request->limit,
        ]);
        $user = User::find($id);
        $user->roles()->sync([$request->role]);
        toastr()->success("User edited");
        return redirect('/admin/users');
    }

    public function destroy($id){
        $user = User::find($id);
        $user->delete();

        toastr()->success("User deleted!");
        return redirect('/admin/users');
    }
}
