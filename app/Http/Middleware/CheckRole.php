<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (Auth::check()) {
            $userRoles = Auth::user()->roles->pluck('name')->toArray();
    
            foreach ($roles as $role) {
                if (in_array($role, $userRoles)) {
                    return $next($request);
                }else{
                    return response()->json([
                        'message' => 'Anda harus login sebagai admin untuk mengakses ini.',
                        'status' => 403
                    ], 403);
                }
            }
    
        }else{
            return response()->json([
                'message' => 'Harus Login.',
                'status' => 401
            ], 401);
        }
    
       
    
       
    }
    
}
