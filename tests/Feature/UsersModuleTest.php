<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UsersModuleTest extends TestCase
{
    /**
    * Pruebas de usuarios
    */
    function test_loads_users_page ()
    {
        $this->get('/usuarios')
            ->assertStatus(200)
            ->assertSee('Usuarios');
    }

    /**
     * Pruebas de detalles de usuario
     */
    function test_loads_users_details_page ()
    {
        $this->get('/usuarios/5')
            ->assertStatus(200)
            ->assertSee("Mostrar detalles del usuario: 5");
    }

    /**
     * Pruebas de nuevo usuario
     */
    function test_loads_new_user_page ()
    {
        $this->get('/usuarios/nuevo')
            ->assertStatus(200)
            ->assertSee("Crear nuevo usuario");
    }
}
