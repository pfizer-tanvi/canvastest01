<?php

namespace Tests\Feature;

use App\Events\RecievedExampleMessageEvent;
use App\Jobs\ProcessNewJob;
use Exception;
use Illuminate\Support\Facades\View;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;

class ProcessNewJobTest extends TestCase
{
    use RefreshDatabase;

    public function testProcessesJobAndLogsOutput(): void
    {


        Log::shouldReceive('info')
            ->once()
            ->with('process new job request on stratus-core-laravel')
            ->andReturnSelf();

        Log::shouldReceive('info')
            ->twice()
            ->with(json_encode(['foo' => 'bar']))
            ->andReturnSelf();

        Log::shouldReceive('info')
            ->once()
            ->with('event received')
            ->andReturnSelf();

        Event::fake();

        $handler = new ProcessNewJob(['foo' => 'bar']);
        $handler->handle();

        Event::assertDispatched(RecievedExampleMessageEvent::class);
    }
}
