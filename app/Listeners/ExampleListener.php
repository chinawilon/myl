<?php

namespace App\Listeners;

use App\Events\LoginFailedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ExampleListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\LoginFailedEvent  $event
     * @return void
     */
    public function handle(LoginFailedEvent $event)
    {
        var_dump('ex:' . $event->ip);
    }
}
