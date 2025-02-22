<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SupabaseTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

          // Cek apakah ada token di URL
          if ($request->query('access_token')) {
            // Simpan token di session
            session([
                'access_token' => $request->query('access_token'),
                'refresh_token' => $request->query('refresh_token'),
            ]);

            // Redirect ke halaman yang sama, tetapi tanpa token di URL
            return redirect()->to($request->url());
        }

        return $next($request);
      
    }
}
