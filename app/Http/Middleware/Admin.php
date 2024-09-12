<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;

class Admin
{
    public function handle(Request $request, \Closure $next)
    {
        // 检查用户是否为管理员
        if (! $request->user()->isAdmin() ) {
            abort(403, 'Access denied');
        }
        return $next($request); // 继续执行请求
    }
}
