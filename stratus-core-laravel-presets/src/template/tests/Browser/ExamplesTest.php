<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ExamplesTest extends DuskTestCase
{
    /**
     * A Dusk test user does not have access to create.
     */
    public function testSeeDashBoardAndAdminArea()
    {
        $user = factory(\App\User::class)->create(['is_super_admin' => true]);
        $this->be($user);
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user->id)->visit('/')
                ->assertSee('Dashboard')
                ->visit('/admin')
                ->assertSee('Admin users');
        });
    }

    /**
     * A Dusk test user does not have access to create.
     */
    public function testSeeDashBoardAndNotSeeAdminArea()
    {
        $user = factory(\App\User::class)->create(['is_super_admin' => false]);
        $this->be($user);
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user->id)->visit('/')
                ->assertSee('Dashboard')
                ->visit('/admin')
                ->assertSee('You can not visit this page due not have permissions');
        });
    }

    /**
     * A Dusk test user does not have access to create.
     */
    public function testAcessExamples()
    {
        $user = factory(\App\User::class)->create(['is_super_admin' => true]);
        $this->be($user);
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user->id)->visit('/')
                ->assertSee('Dashboard')
                ->clickLink($user->email)
                ->clickLink('Admin Area')
                ->assertSee('Example')
                ->click('@example')
                ->assertSee('Upload file to S3 and list');
        });
    }
}
