<?php

namespace App\Http\Middleware;

use App\Exceptions\ApiException;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class Initialization
{

    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * @throws ApiException
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $token = $request->header('LM-TOKEN');

        if (!$token || !($payload = Cache::get('init:'.$token))) {
            throw new ApiException(ApiException::ERROR_TOKEN_NOT_FOUND);
        }

        // 传递上下文
        Request::macro('tokenInfo', function () use($payload) {
            return $payload;
        });
        
        return $next($request);
    }
}
