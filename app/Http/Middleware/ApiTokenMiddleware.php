<?php

namespace App\Http\Middleware;

use App\Domains\User\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiTokenMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $authHeader = (string) $request->header('Authorization', '');
        if (! str_starts_with($authHeader, 'Bearer ')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $plain = substr($authHeader, 7);
        $hash = hash('sha256', $plain);

        $row = DB::table('personal_access_tokens')->where('token', $hash)->first();
        if (! $row) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        if ($row->tokenable_type !== User::class) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = User::find($row->tokenable_id);
        if (! $user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $request->attributes->set('auth_user', [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ]);
        $request->attributes->set('auth_token_hash', $hash);

        DB::table('personal_access_tokens')->where('id', $row->id)->update(['last_used_at' => now()]);

        return $next($request);
    }
}


