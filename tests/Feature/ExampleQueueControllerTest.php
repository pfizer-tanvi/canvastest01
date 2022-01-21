<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ExampleQueueControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        $this->withoutMiddleware();
        $this->get(route("queue-worker-example"))
            ->assertStatus(200)
            ->assertSee('Queue Send/Receive Example');
    }
}
