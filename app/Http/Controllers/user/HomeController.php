<?php

namespace App\Http\Controllers\user;

use App\Models\User;
use App\Models\Products;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
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

  //   $validator  = $request->validate(
  //     [
  //       'name'      => 'required',
  //       'email'     => 'required|unique:users',
  //       'password'  => 'required|min:6',
  //       // 'confirmed' => 'required|same:password:6',
  //   ]
  // );
  // if ($validator->fails()) {
  //   return redirect()->back()->with(['error' => "Something Went Wrong"]);
  // }
    $data['name']       = $request->name;
    $data['email']      = $request->email;
    $data['password']   = Hash::make($request->password);
    $data['role']       = "customer";
    $user = User::create($data);

    if(!$user){
      return redirect()->back()->with(['error' => 'something went wrong']);
    }

    return redirect()->route('index')->with(['success'=> 'Account Created']);

  }

  function api_product(){
    $products = Products::get();
    for($i = 0; $i<count($products); $i++){
      $products[$i]['image'] = route('index'). $products[$i]['image'];
    }
    return response()->json($products);
  }
}
