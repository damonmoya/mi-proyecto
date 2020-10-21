<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WelcomeUsersTest extends TestCase
{
    /**
     * Prueba de saludo con nickname
     */
    function test_loads_welcome_user_nickname_page ()
    {
        $this->get('/saludo/pepe/bobui')
            ->assertStatus(200)
            ->assertSee("Bienvenido Pepe, tu nick es bobui");
    }

    /**
     * Prueba de saludo sin nickname
     */
    function test_loads_welcome_user_no_nickname_page ()
    {
        $this->get('/saludo/pepe')
            ->assertStatus(200)
            ->assertSee("Bienvenido Pepe");
    }
}
