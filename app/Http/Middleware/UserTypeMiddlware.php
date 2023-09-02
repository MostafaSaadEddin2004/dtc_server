<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserTypeMiddlware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if($role == 'admin' && auth()->user()->role->name != 'admin'){
            return response(['message' => 'unauthorized'], 401);
        }
        if($role == 'student_browser' && auth()->user()->role->name != 'student_browser'){
            return response(['message' => 'unauthorized'], 401);
        }
        if($role == 'teacher_browser' && auth()->user()->role->name != 'teacher_browser'){
            return response(['message' => 'unauthorized'], 401);
        }
        if($role == 'student' && auth()->user()->role->name != 'student'){
            return response(['message' => 'unauthorized'], 401);
        }
        if($role == 'teacher' && auth()->user()->role->name != 'teacher'){
            return response(['message' => 'unauthorized'], 401);
        }
        return $next($request);
    }
}
