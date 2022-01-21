<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\CognitoUserServiceLaravel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;

class CognitoUserServiceLaravelTest extends FeatureTestCase
{
    use RefreshDatabase;

    public function testCreatesAndAssignsRoles(): void
    {
        $user = User::factory()->create();
        $cognito_payload = File::get(base_path("tests/fixtures/cognito_user_fixture.json"));
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

    public function testCreateUserRolesAndAssign(): void
    {
        $cognito_payload = File::get(base_path("tests/fixtures/cognito_user_fixture.json"));
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
