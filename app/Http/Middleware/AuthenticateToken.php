<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $bearerToken = $request->header('authorization');
        $token = '';
        if ($bearerToken && Str::start($bearerToken, 'Bearer ')) {
            $token = substr($bearerToken, 7); // Remove 'Bearer ' prefix

            $user = User::where('token', $token)->first();
            if ($user) {
                Auth::login($user); // Manually authenticate the user
                return $next($request);
            } else {
                return response()->json(['status' => 'Error', 'message' => 'Unauthenticated User.'], 401);
            }
        } else {
            $token = $bearerToken;
            return response()->json(['status' => 'Error', 'message' => 'Unauthenticated User.'], 401);
        }
    }
}
