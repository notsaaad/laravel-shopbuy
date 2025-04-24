<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Products;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\user\newuserRequest;

class AuthController extends Controller
{


  function login(){
    return view('user.login');
  }


  
  function postLogin(Request $request){

    $credentials = $request->only('email', 'password');

    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    $user = User::where('email', $credentials['email'])->first();
    if ($user && Hash::check($credentials['password'], $user->password)) {
        Auth::login($user);
        return redirect()->route('index')->with(['success'=> 'Login Successfully']);
    }

    return back()->with(['error'=> 'Username or Password Wrong']);
  }



  function Signup(){
    return view('user.signup');
  }

  function new_user(newuserRequest $request){

    $data['name']       = $request->name;
    $data['email']      = $request->email;
    $data['password']   = $request->password;
    $data['role']       = "customer";
    $user = User::create($data);


    if(!$user){
      return redirect()->back()->with(['error' => 'something went wrong']);
    }
    $id   = $user->id;
    Auth::loginUsingId($id);
    return redirect()->route('index')->with(['success'=> 'Account Created']);
  }


  function logout(){
    Auth::logout();
    return redirect()->route('login')->with(['success'=> 'Logout  Successfully']);
  }
  function api_product(){
    $products = Products::get();
    for($i = 0; $i<count($products); $i++){
      $products[$i]['image'] = route('index').'/'. $products[$i]['image'];
    }
    return response()->json($products);
  }
}
