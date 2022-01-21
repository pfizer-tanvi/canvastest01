<?php

namespace Tests\Feature;

use App\Services\CognitoUserServiceLaravel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CognitoUserServiceLaravelTest extends TestCase
{
    use RefreshDatabase;

    public function testCreatesAndAssignsRoles()
    {
        $user = \App\Models\User::factory()->create();
        $cognito_payload = \File::get(base_path("tests/fixtures/cognito_user_fixture.json"));
        $cognito_payload = json_decode($cognito_payload, true);
        /** @var CognitoUserServiceLaravel $service */
        $service = $this->app->makeWith(CognitoUserServiceLaravel::class, ['user' => $user]);
        $cognito_payload = (object) $cognito_payload;
        $cognito_payload->identities = (object) ['userId' => "foobar"];
        $user = $service->mapToUser($cognito_payload);
        $this->assertDatabaseHas('roles', [
            'name' => "GBL-PFE-NON-COLLEAGUES-U"
        ]);
        $this->assertCount(5, $user->refresh()->roles->toArray());
    }

    public function testCreateUserRolesAndAssign()
    {
        $cognito_payload = \File::get(base_path("tests/fixtures/cognito_user_fixture.json"));
        $cognito_payload = json_decode($cognito_payload, true);
        /** @var CognitoUserServiceLaravel $service */
        $service = $this->app->makeWith(CognitoUserServiceLaravel::class, ['user' => new User()]);
        $cognito_payload = (object) $cognito_payload;
        $cognito_payload->identities = (object) ['userId' => "foobar"];
        $user = $service->mapToUser($cognito_payload);
        $this->assertDatabaseHas('roles', [
            'name' => "GBL-PFE-NON-COLLEAGUES-U"
        ]);
        $this->assertCount(5, User::first()->roles->toArray());
    }
}
