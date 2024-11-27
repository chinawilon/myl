<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Crypto
{
    public function handle(Request $request, Closure $next): Response
    {
        $this->handleDecrypt($request);
        return $this->handleEncrypt($request, $next($request));
    }

    /**
     * @param Request $request
     * @return void
     */
    public function handleDecrypt(Request $request): void
    {
        $payload = [];
        $request->merge($payload);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function handleEncrypt(Request $request, Response $response): Response
    {
        // 对内容进行加密
        $content = $response->getContent();
        $response->setContent($content);
        if ( $response instanceof JsonResponse && $callback = $request->input('callback') ) {
            $response->withCallback($callback);
        }
        return $response;
    }
}
