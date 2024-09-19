<?php

namespace App\Listeners;

use App\Events\LoginFailedEvent;

class LoginFailedListener
{
    public function handle(LoginFailedEvent $event)
    {
        // 处理登录失败事件
//        var_dump($event->ip);
    }
}
