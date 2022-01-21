<?php

namespace Tests\Feature;

use App\Http\Requests\CreateSupportRequestValidation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

class CreateSupportRequestValidationTest extends TestCase
{

    public function testRules()
    {
        $validator = new CreateSupportRequestValidation();

        $this->assertEquals([
            'title' => "required",
            "description" => "required"
        ], $validator->rules());
    }

    public function testTypeInRules()
    {
        Gate::shouldReceive('allows')
            ->with('feature-flag', 'support-request-type')
            ->once()->andReturn(true);

        $validator = new CreateSupportRequestValidation();

        $this->assertEquals([
            'title' => "required",
            "description" => "required",
            "type" => "required"
        ], $validator->rules());
    }
}
