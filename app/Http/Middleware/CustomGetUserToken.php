<?php

namespace App\Http\Middleware;

use App\Models\Mentee;
use App\Models\Mentor;
use Closure;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use JWTAuth;
use Auth;

class CustomGetUserToken extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     * @throws JWTException
     */
    public function handle($request, Closure $next)
    {
        if (! $this->auth->setRequest($request)->getToken()) {
            throw new JWTException('Token not provided', 400);
        }

        $jwt = JWTAuth::parseToken()->getPayload();
        $userInfo = null;

        if ($jwt->get('user_type') === "MENTOR" && !$userInfo = Mentor::find($jwt->get('id'))) {
            throw new JWTException('User not found', 404);
        } elseif ($jwt->get('user_type') === "MENTEE" && !$userInfo = Mentee::find($jwt->get('id'))) {
            throw new JWTException('User not found', 404);
        }

        $request->merge([
            'user_type' => $jwt->get('user_type'),
            'id' => $jwt->get('id'),
            'homi' => $userInfo->homi,
        ]);

        return $next($request);
    }
}
