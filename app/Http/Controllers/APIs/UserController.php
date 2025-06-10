<?php

namespace App\Http\Controllers\APIs;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
  function index(){
    $users = User::get();
    return response()->json([
    'status' => true,
    'message' => 'users retrieved successfully.',
    'data' => $users,
    ], 200);
  }
}
