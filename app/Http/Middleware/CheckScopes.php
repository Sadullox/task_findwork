<?php

namespace App\Http\Middleware;

use Illuminate\Auth\AuthenticationException;
use Laravel\Passport\Exceptions\MissingScopeException;

class CheckScopes
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed  ...$scopes
     * @return \Illuminate\Http\Response
     *
     * @throws \Illuminate\Auth\AuthenticationException|\Laravel\Passport\Exceptions\MissingScopeException
     */
    public function handle($request, $next, ...$scopes)
    {
        $user = null;
        foreach ($scopes as $scope) {
            if ($request->user($scope) && $request->user($scope)->tokenCan($scope)) {
                $user = $request->user($scope);
            }
        }
        if (!$user) {
            return response()->json([
                'success' => false,
                'code'    => 401,
                'message' => __('messages.not_auth'),
                'error' => [
                ]
            ],
            401);
        }

        return $next($request);
    }
}
