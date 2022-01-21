<?php

namespace Tests\Feature;

use App\Jobs\ProcessNewJob;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;

class SendMessageControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testSendMessage()
    {
        Bus::fake();
        $this->withoutMiddleware();
        $response = $this->post(route("send-message-example"))
            ->assertStatus(200)
            ->json();

        $this->assertEquals($response, 'sent');
        Bus::assertDispatched(ProcessNewJob::class);
    }
}
