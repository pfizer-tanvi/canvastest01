<?php

namespace App\Listeners;

use App\Events\ResponseHook;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ResponseHookExampleListener
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
    public function handle(ResponseHook $event)
    {
        $data = $event->data;
        $data['plugin_one'] = ['foo' => 'bar'];
        return $data;
    }
}
