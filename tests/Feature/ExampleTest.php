<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_root_displays_the_welcome_page(): void
    {
        $response = $this->get('/');

        $response->assertOk();
    }
}
