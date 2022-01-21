<?php

namespace Tests\Feature;

use Tests\TestCase;

abstract class FeatureTestCase extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMix();
    }
}
