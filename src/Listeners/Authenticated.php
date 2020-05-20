<?php

namespace Den1n\ConcurrentSessions\Listeners;

use Illuminate\Auth\Events\Authenticated as AuthenticatedEvent;
use Illuminate\Support\Facades\Session;

class Authenticated
{
    /**
     * Handle the event.
     */
    public function handle(AuthenticatedEvent $event): void
    {
        if ($user = $event->user and $user->sessions_limit) {
            $id = Session::getId();

            if (!in_array($id, $user->sessions))
                $user->sessions = array_merge($user->sessions, [$id]);
        }
    }
}
