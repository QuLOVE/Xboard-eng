<?php

namespace App\Http\Middleware;

use App\Exceptions\ApiException;
use App\Services\AuthService;
use Closure;
use Illuminate\Support\Facades\Cache;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $authorization = $request->input('auth_data') ?? $request->header('authorization');
        if (!$authorization) throw new ApiException('Not logged in or login has expired', 403);

        $user = AuthService::decryptAuthData($authorization);
        if (!$user || !$user['is_admin']) throw new ApiException('Not logged in or login has expired',403);
        $request->merge([
            'user' => $user
        ]);
        return $next($request);
    }
}
