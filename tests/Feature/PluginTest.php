<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PluginTest extends TestCase
{
    public function testPlugins()
    {
        $json = $this->json("GET", "/plugins")->assertStatus(200)->json();

        $this->assertNotEmpty($json);
        $this->assertArrayHasKey('plugin_one', $json);
        $this->assertArrayHasKey('plugin_two', $json);
    }
}
