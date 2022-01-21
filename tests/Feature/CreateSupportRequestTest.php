<?php

namespace Tests\Feature;

use App\Mail\SupportRequestMail;
use Facades\App\Services\CreateSupportRequest;
use App\Models\SupportRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class CreateSupportRequestTest extends TestCase
{
    use RefreshDatabase;

    public function testHandlePayload()
    {
        Mail::fake();
        $payload = [
            'title' => "foo",
            "description" => "bar"
        ];

        $results = CreateSupportRequest::handle($payload);

        $this->assertInstanceOf(SupportRequest::class, $results);
        $this->assertNotNull($results->title);
        $this->assertNotNull($results->description);
    }

    public function testSendsToCorrectEmail()
    {
        Mail::fake();
        $payload = [
            'title' => "foo",
            "description" => "bar",
            "type" => "feature"
        ];

        $results = CreateSupportRequest::handle($payload);

        $this->assertInstanceOf(SupportRequest::class, $results);
        $this->assertNotNull($results->title);
        $this->assertNotNull($results->description);

        Mail::assertSent(function (SupportRequestMail $mail) use ($results) {
            return $mail->hasTo("support+features@foo.com");
        });
    }
}
