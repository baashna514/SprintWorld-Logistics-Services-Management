<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Validation\Rules;

class UserController extends Controller
{

    public function index(){
        $users = User::all();
        return view('users.list')->with('users', $users);
    }

    public function create(): View
    {
        $roles = Role::all();
        return view('auth.register')->with('roles', $roles);
    }
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => 'required',
        ]);
        if (!isset($request->role)){
            return Redirect::back()->withErrors(['msg' =>'You are not authorized to register User.']);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $user->assignRole($request->role);
        return Redirect::route('users')->with('success', 'User created successfully!');
    }

    public function getUserDetails($id){
        $user = User::find($id);
        return view('users.view')->with('user', $user);
    }

    public function updateUserDetails(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($id),
            ],
        ]);

        if ($validator->fails()) {
            return redirect()->route('users', $id)
                ->withErrors($validator)
                ->withInput();
        }

        User::query()->find($id)->update([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
        ]);
        return Redirect::route('users')->with('success', 'User updated successfully!');

    }

    public function user_change_status($id){
        $user = User::query()->find($id);
        if($user->status == true){
            $user->status = false;
            $msg = 'User disabled successfully!';
        }elseif($user->status == false){
            $user->status = true;
            $msg = 'User enabled successfully!';
        }
        $user->save();
        return Redirect::route('users')->with('success', $msg);
    }
}
