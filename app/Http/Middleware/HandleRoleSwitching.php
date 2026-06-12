<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class HandleRoleSwitching
{
    public function handle(Request $request, Closure $next): Response
    {
        if (session()->has('switched_to_role') && session()->has('original_user_id')) {
            $originalUser = User::find(session('original_user_id'));

            /** @var \App\Models\User $originalUser */
            if ($originalUser && $originalUser->hasRole('admin')) {
                // Login sebagai user yang sedang login, tapi ganti perannya secara temporer
                /** @var \App\Models\User $user */ // <-- TAMBAHKAN PETUNJUK INI
                $user = Auth::user();
                $user->syncRoles([session('switched_to_role')]);
            }
        }

        return $next($request);
    }
}