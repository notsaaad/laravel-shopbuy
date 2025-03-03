<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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

  }
}
