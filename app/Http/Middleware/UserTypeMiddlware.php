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
        if($role != auth()->user()->role->name ){
            return response(['message' => 'unauthorized'], 401);
        }
        if($role != auth()->user()->role->name ){
            return response(['message' => 'unauthorized'], 401);
        }
        if($role != auth()->user()->role->name ){
            return response(['message' => 'unauthorized'], 401);
        }
        if($role != auth()->user()->role->name ){
            return response(['message' => 'unauthorized'], 401);
        }
        if($role != auth()->user()->role->name ){
            return response(['message' => 'unauthorized'], 401);
        }
        return $next($request);
    }
}