<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UsersModuleTest extends TestCase
{

    use refreshDatabase;

    /**
    * Pruebas de usuarios
    */
    function test_show_users_page ()
    {

        User::factory()->create([
            'name' => 'Pepe',
        ]);

        User::factory()->create([
            'name' => 'Pablo',
        ]);

        User::factory()->create([
            'name' => 'Willy',
        ]);

        $this->get('/usuarios')
            ->assertStatus(200)
            ->assertSee('Listado de usuarios')
            ->assertSee('Pepe')
            ->assertSee('Pablo')
            ->assertSee('Willy');
    }

    function test_empty_users_page ()
    {
        $this->get('/usuarios')
            ->assertStatus(200)
            ->assertSee('Listado de usuarios')
            ->assertSee('No hay usuarios registrados');
    }

    /**
     * Pruebas de detalles de usuario
     */
    function test_loads_users_details_page ()
    {

        $user = User::factory()->create([
            'name' => 'Pepe Benavente',
        ]);

        $this->get('/usuarios/'.$user->id)
            ->assertStatus(200)
            ->assertSee("Pepe Benavente");
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
