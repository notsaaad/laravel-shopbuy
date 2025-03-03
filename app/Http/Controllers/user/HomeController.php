<?php

namespace App\Http\Controllers\user;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\user\newuserRequest;

class HomeController extends Controller
{
  function home(){
    return view('user.home');
  }

  function store(){
    return view('user.store');
  }




  function login(){
    return view('user.login');
  }

  function Signup(){
    return view('user.signup');
  }

  function new_user(newuserRequest $request){

    $data['name']       = $request->name;
    $data['email']      = $request->email;
    $data['password']   = Hash::make($request->password);
    $data['role']       = "customer";
    $user = User::create($data);

    if($user){
      return redirect()->route('index')->with(['success' => 'Account Created']);
    }


    return redirect()->route('Signup')->with(['error' => 'something went wrong']);
  }
}
