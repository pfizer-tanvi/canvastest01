<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SupportRequestCreateControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testSuccess()
    {

        $user = \App\Models\User::factory()->create();

        $this->be($user);

        $payload = [
            'title' => "foo",
            'description' => "bar",
        ];

        $this->post(
            route("support_requests.create"),
            $payload
        )->assertStatus(200);

        $this->assertDatabaseHas("support_requests", $payload);
    }

    public function testValidationFail()
    {
        $user = \App\Models\User::factory()->create();

        $this->be($user);

        $this->post(
            route("support_requests.create"),
            [
                'title' => "",
                'description' => "bar",
            ]
        )->assertStatus(302);
    }
}
