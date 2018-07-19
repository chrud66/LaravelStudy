<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;
use Illuminate\Contracts\Events\Dispatcher;

class UserEventsHandler
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
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        //
    }

    /**
     * Map events and handlers
     *
     * @param Dispatcher $events
     */
    public function subscribe(Dispatcher $events)
    {
        $events->listen(
            'users.login',
            __CLASS__ . '@onUserLogin'
        );
    }

    /**
     * User login event handler
     *
     * @param \App\User $user
     */
    public function onUserLogin(User $user)
    {
        // Update last_login field
        $user->last_login = \Carbon\Carbon::now()->toDateTimeString();
        $user->save();
    }
}
