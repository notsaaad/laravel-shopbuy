<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
  function login(){
    return view('admin.index');
  }

  function postLogin(Request $request){
    $credentials = $request->only('email', 'password');
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    $user = User::where('email', $credentials['email'])->first();

    if ($user && Hash::check($credentials['password'], $user->password)) {
        Auth::login($user, true);
        return redirect()->route('admin.home')->with(['success'=> 'Login Successfully']);
    }

    return back()->with(['error'=> 'Username or Password Wrong']);
  }
}
