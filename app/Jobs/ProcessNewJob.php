<?php

namespace App\Jobs;

use App\Events\RecievedExampleMessageEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessNewJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Request array
     *
     * @var array
     */
    private $request_array = [];

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $request_array)
    {
        $this->request_array = $request_array;
    }

    /**
     * Execute the' job.
     *
     * @return void
     */
    public function handle(): void
    {
        Log::info('process new job request on stratus-core-laravel');
        Log::info(json_encode($this->request_array, JSON_THROW_ON_ERROR));
        event(new RecievedExampleMessageEvent($this->request_array));
    }
}
