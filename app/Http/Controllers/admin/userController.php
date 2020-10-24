<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class userController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $users = User::all();
        return view('admin.user_management.index')->with('users',$users);
    }
    public function create()
    {
        $roles = Role::all();
        return view('admin.user_management.create')->with('roles',$roles);
    }
    public function store(Request $request, User $user)
    {
        if (Gate::denies('store')) {
            return redirect()->route('users.index')->with('warning','yo dont have authorize! pliz contak yo admin.');
        }
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user->name = $request->name;
        $user->password = Hash::make($request->password);
        $user->email = $request->email;

        if ($user->save()) {
            $request->session()->flash('success','User has been saved!');
        } else {
            $request->session()->flash('error','There was an error!');
        }

        $user->roles()->sync($request->roles);
        
        return redirect()->route('users.index');
    }

    public function edit(User $user)
    {
        if (Gate::denies('edit')) {
            return redirect()->route('users.index')->with('warning','yo dont have authorize! pliz contak yo admin.');
        }
        $roles = Role::all();
        return view('admin.user_management.edit')->with([
            'user'=>$user,
            'roles'=>$roles,
        ]);
    }
    public function update(Request $request, User $user)
    {
        if (Gate::denies('update')) {
            return redirect()->route('users.index')->with('warning','yo dont have authorize! pliz contak yo admin.');
        }

        $user->roles()->sync($request->roles);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($user->save()) {
            $request->session()->flash('success','User has been updated!');
        } else {
            $request->session()->flash('error','There was an error!');
        }
        
        return redirect()->route('users.index');
    }
    public function destroy(Request $request, User $user)
    {
        if (Gate::denies('delete')) {
            return redirect()->route('users.index')->with('warning','yo dont have authorize! pliz contak yo admin.');
        }

        $user->roles()->detach();

        if ($user->delete()) {
            $request->session()->flash('success','User has been deleted!');
        } else {
            $request->session()->flash('error','There was an error!');
        }

        return redirect()->route('users.index');
    }
}
