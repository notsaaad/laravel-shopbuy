<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class isAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!Auth::check() && $request->routeIs('admin.index')){
          return $next($request);
        }
        if(!Auth::check())
          return redirect()->route('admin.index')->with(['error'=> 'Log in']);
        $role = Auth::user()->role;
        if($role != 'admin'){
          return redirect()->route('index')->with(['error'=> 'your are not allowed']);
        }
        if($request->routeIs('admin.index')){
          return redirect()->route('admin.home');
        }
        return $next($request);
    }
}
