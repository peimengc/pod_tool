<?php

namespace App\Listeners;

use App\Events\DouyinCookieInvalid;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ClearDouyinUserCookie
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
     * @param DouyinCookieInvalid $event
     * @return void
     */
    public function handle(DouyinCookieInvalid $event)
    {
        $event->douyinUser->dy_cookie = null;
        $event->douyinUser->save();
    }
}
