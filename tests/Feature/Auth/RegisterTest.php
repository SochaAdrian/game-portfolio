<?php

namespace Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function testBasic()
    {
        $this->assertTrue(true);
    }
}
