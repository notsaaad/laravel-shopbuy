<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
  function home(){
    return view('user.home')->with(['success'=> 'tostr Work']);
  }


}
