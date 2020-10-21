<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WelcomeUsersTest extends TestCase
{
    /**
     * @test
     */
    function test_loads_welcome_user_nickname_page ()
    {
        $this->get('/saludo/pepe/bobui')
            ->assertStatus(200)
            ->assertSee("Bienvenido Pepe, tu nick es bobui");
    }

    /**
     * @test
     */
    function test_loads_welcome_user_no_nickname_page ()
    {
        $this->get('/saludo/pepe')
            ->assertStatus(200)
            ->assertSee("Bienvenido Pepe");
    }
}
