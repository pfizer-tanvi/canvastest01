<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SupportRequestTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testModelAndFactoryWork()
    {
        $model = \App\Models\SupportRequest::factory()->create();
        $this->assertNotNull($model->title);
        $this->assertNotNull($model->description);
        $this->assertNotNull($model->type);
    }
}
