<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

    public function index(){
        $users=User::all();
        return view('admin.users.index',['users'=>$users]);
    }
    public function show(User $user){
        // $post=$user->posts()->findOrFail(2);
        // dd($user);
        return view ('admin.users.profile',['user'=>$user,
        'roles'=>Role::all()]);
    }
    public function update(User $user){
        $inputs=request()->validate([
            'username'=>['required','string','max:255','alpha_dash'],
            'name'=>['required','string','max:255' ],
            'email'=>['required','email','max:255' ],
            'avatar'=>['file' ],
            // 'password'=>['min:6','max:255','confirmed']

        ]);

        if(request('avatar')){
            $inputs['avatar']=request('avatar')->store('images');

        }
        $user->update($inputs);
        return back();
    }
    public function getUserImage($user_id)
    {
        $user = User::findOrFail($user_id);
        $image = Storage::disk('')->get($user->avatar);

        return $image;

    }
    public function destroy(User $user){
  $user->delete();
  session()->flash('user-deleted','User has beeen deleted');
  return back();
    }
public function attach(User $user){
    // dd(request('role'));
    $user->roles()->attach(request('role'));
    return back();
}
public function detach(User $user){
    // dd(request('role'));
    $user->roles()->detach(request('role'));
    return back();
}
}
