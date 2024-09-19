<?php

namespace App\Events;

class LoginFailedEvent extends Event
{
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(public array $credentials, public string $ip)
    {
        //
    }
}
