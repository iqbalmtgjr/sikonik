<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UpdateLastActivity
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $user_id = Auth::user()->id;
            $user = User::find($user_id);
            $user->update(['is_online' => true]);
        }
        return $next($request);
    }
}
