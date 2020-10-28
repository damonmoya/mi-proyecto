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
     * Pruebas de carga de páginas
     */
    function test_loads_new_user_page ()
    {
        $this->get('/usuarios/nuevo')
            ->assertStatus(200)
            ->assertSee("Crear usuario");
    }

    function test_loads_edit_user_page ()
    {
        $user = User::factory()->create();

        $this->get("/usuarios/{$user->id}/editar")
            ->assertStatus(200)
            ->assertViewIs('users.edit')
            ->assertSee("Editar usuario")
            ->assertViewHas('user', function ($viewUser) use ($user) {
                return $viewUser->id == $user->id;
            });
    }

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
     * Pruebas de usuario no encontrado
     */
    function test_404_user_does_not_exist ()
    {
        $this->get('/usuarios/999')
            ->assertStatus(404)
            ->assertSee("Página no encontrada");
    }

    /**
     * Pruebas de creación de usuario
     */
    function test_creates_a_new_user ()
    {
        $this->post('/usuarios/', [
            'name' => 'Pepe2',
            'email' => 'pepebenavente2@hotmail.es',
            'password' => 'elmejorcantante',
            'confirm_password' => 'elmejorcantante'
        ])->assertRedirect('/usuarios');

        $this->assertCredentials([
            'name' => 'Pepe2',
            'email' => 'pepebenavente2@hotmail.es',
            'password' => 'elmejorcantante'
        ]);
    }

    function test_name_is_required ()
    {
        $this->from('usuarios/nuevo')
            ->post('/usuarios/', [
                'name' => '',
                'email' => 'pepebenavente2@hotmail.es',
                'password' => 'elmejorcantante'
        ])->assertRedirect('usuarios/nuevo')
            ->assertSessionHasErrors(['name' => 'El campo nombre es obligatorio']);


        $this->assertEquals(0, User::count());

    }

    function test_email_is_required ()
    {
        $this->from('usuarios/nuevo')
            ->post('/usuarios/', [
                'name' => 'Pepe2',
                'email' => '',
                'password' => 'elmejorcantante'
        ])->assertRedirect('usuarios/nuevo')
            ->assertSessionHasErrors(['email' => 'El campo correo es obligatorio']);


        $this->assertEquals(0, User::count());

    }

    function test_password_is_required ()
    {
        $this->from('usuarios/nuevo')
            ->post('/usuarios/', [
                'name' => 'Pepe2',
                'email' => 'pepebenavente2@hotmail.es',
                'password' => ''
        ])->assertRedirect('usuarios/nuevo')
            ->assertSessionHasErrors(['password' => 'El campo clave es obligatorio']);


        $this->assertEquals(0, User::count());

    }

    function test_email_muest_be_valid ()
    {
        $this->from('usuarios/nuevo')
            ->post('/usuarios/', [
                'name' => 'Pepe2',
                'email' => 'correo-no-valido',
                'password' => 'elmejorcantante'
        ])->assertRedirect('usuarios/nuevo')
            ->assertSessionHasErrors(['email']);


        $this->assertEquals(0, User::count());

    }

    function test_email_must_be_unique ()
    {
        User::factory()->create([
            'email' => 'pepebenavente2@hotmail.es',
        ]);

        $this->from('usuarios/nuevo')
            ->post('/usuarios/', [
                'name' => 'Pepe2',
                'email' => 'pepebenavente2@hotmail.es',
                'password' => 'elmejorcantante'
        ])->assertRedirect('usuarios/nuevo')
            ->assertSessionHasErrors(['email']);


        $this->assertEquals(1, User::count());

    }

    function test_password_must_have_min_length ()
    {

        $this->from('usuarios/nuevo')
            ->post('/usuarios/', [
                'name' => 'Pepe2',
                'email' => 'pepebenavente2@hotmail.es',
                'password' => '12345'
        ])->assertRedirect('usuarios/nuevo')
            ->assertSessionHasErrors(['password']);


        $this->assertEquals(0, User::count());

    }

    function test_password_and_confirm_password_are_not_same ()
    {

        $this->from('usuarios/nuevo')
            ->post('/usuarios/', [
                'name' => 'Pepe2',
                'email' => 'pepebenavente2@hotmail.es',
                'password' => 'elmejorcantante',
                'confirm_password' => 'elmejorcantante2'
        ])->assertRedirect('usuarios/nuevo')
            ->assertSessionHasErrors(['confirm_password']);


        $this->assertEquals(0, User::count());

    }

    /**
     * Pruebas de actualización de usuario
     */

    function test_updates_a_user ()
    {

        //$this->withoutExceptionHandling();

        $user = User::factory()->create();

        $this->put("/usuarios/{$user->id}", [
            'name' => 'Pepe2',
            'email' => 'pepebenavente2@hotmail.es',
            'password' => 'elmejorcantante',
            'confirm_password' => 'elmejorcantante'
        ])->assertRedirect("/usuarios/{$user->id}");

        $this->assertCredentials([
            'name' => 'Pepe2',
            'email' => 'pepebenavente2@hotmail.es',
            'password' => 'elmejorcantante'
        ]);
    }

    function test_update_name_is_required ()
    {

        //$this->withoutExceptionHandling();

        $user = User::factory()->create();

        $this->from("usuarios/{$user->id}/editar")
            ->put("/usuarios/{$user->id}", [
            'name' => '',
            'email' => 'pepebenavente2@hotmail.es',
            'password' => 'elmejorcantante',
            'confirm_password' => 'elmejorcantante'
        ])->assertRedirect("/usuarios/{$user->id}/editar")
            ->assertSessionHasErrors(['name']);

        $this->assertDatabaseMissing('users', ['email' => 'pepebenavente2@hotmail.es']);
        
    }

    function test_update_email_is_required ()
    {
        //$this->withoutExceptionHandling();

        $user = User::factory()->create();

        $this->from("usuarios/{$user->id}/editar")
            ->put("/usuarios/{$user->id}", [
            'name' => 'Pepe2',
            'email' => '',
            'password' => 'elmejorcantante',
            'confirm_password' => 'elmejorcantante'
        ])->assertRedirect("/usuarios/{$user->id}/editar")
            ->assertSessionHasErrors(['email']);

        $this->assertDatabaseMissing('users', ['name' => 'Pepe2']);

    }

    function test_update_password_is_optional ()
    {
        //$this->withoutExceptionHandling();

        $user = User::factory()->create([
            'password' => bcrypt('clave_anterior')
        ]);

        $this->from("usuarios/{$user->id}/editar")
            ->put("/usuarios/{$user->id}", [
            'name' => 'Pepe2',
            'email' => 'pepebenavente2@hotmail.es',
            'password' => '',
            'confirm_password' => ''
        ])->assertRedirect("/usuarios/{$user->id}");

        $this->assertCredentials([
            'name' => 'Pepe2',
            'email' => 'pepebenavente2@hotmail.es',
            'password' => 'clave_anterior'
            
        ]);

    }

    function test_update_email_not_changed ()
    {
        //$this->withoutExceptionHandling();

        $user = User::factory()->create([
            'email' => 'pepebenavente2@hotmail.es'
        ]);

        $this->from("usuarios/{$user->id}/editar")
            ->put("/usuarios/{$user->id}", [
            'name' => 'Pepe2',
            'email' => 'pepebenavente2@hotmail.es',
            'password' => '123456',
            'confirm_password' => '123456'
        ])->assertRedirect("/usuarios/{$user->id}");

        $this->assertDatabaseHas('users', [
            'name' => 'Pepe2',
            'email' => 'pepebenavente2@hotmail.es'
        ]);

    }

    function test_update_email_muest_be_valid ()
    {
        //$this->withoutExceptionHandling();

        $user = User::factory()->create();

        $this->from("usuarios/{$user->id}/editar")
            ->put("/usuarios/{$user->id}", [
            'name' => 'Pepe2',
            'email' => 'correo-no-valido',
            'password' => 'elmejorcantante',
            'confirm_password' => 'elmejorcantante'
        ])->assertRedirect("/usuarios/{$user->id}/editar")
            ->assertSessionHasErrors(['email']);

        $this->assertDatabaseMissing('users', ['name' => 'Pepe2']);

    }

    function test_update_email_must_be_unique ()
    {
        User::factory()->create([
            'email' => 'correo-existente@hotmail.es',
        ]);

        $user = User::factory()->create([
            'email' => 'pepebenavente2@hotmail.es',
        ]);

        $this->from("usuarios/{$user->id}/editar")
            ->put("/usuarios/{$user->id}", [
                'name' => 'Pepe2',
                'email' => 'correo-existente@hotmail.es',
                'password' => 'elmejorcantante'
        ])->assertRedirect("/usuarios/{$user->id}/editar")
            ->assertSessionHasErrors(['email']);

    }

    function test_update_password_must_have_min_length ()
    {

        //$this->withoutExceptionHandling();

        $user = User::factory()->create([
            'name' => 'Pepe2',
            'email' => 'pepebenavente2@hotmail.es',
            'password' => bcrypt('clave_anterior')
        ]);

        $this->from("usuarios/{$user->id}/editar")
            ->put("usuarios/{$user->id}", [
                'name' => 'Pepe2',
                'email' => 'pepebenavente2@hotmail.es',
                'password' => '12345'
        ])->assertRedirect("/usuarios/{$user->id}/editar")
            ->assertSessionHasErrors(['password']);

        $this->assertCredentials([
            'name' => 'Pepe2',
            'email' => 'pepebenavente2@hotmail.es',
            'password' => 'clave_anterior'
                
        ]);

    }

    function test_update_password_and_confirm_password_are_not_same ()
    {
        $user = User::factory()->create([
            'name' => 'Pepe2',
            'email' => 'pepebenavente2@hotmail.es',
            'password' => bcrypt('clave_anterior')
        ]);

        $this->from("usuarios/{$user->id}/editar")
            ->put("usuarios/{$user->id}", [
                'name' => 'Pepe2',
                'email' => 'pepebenavente2@hotmail.es',
                'password' => 'elmejorcantante',
                'confirm_password' => 'elmejorcantante2'
        ])->assertRedirect("usuarios/{$user->id}/editar")
            ->assertSessionHasErrors(['confirm_password']);


        $this->assertCredentials([
            'name' => 'Pepe2',
            'email' => 'pepebenavente2@hotmail.es',
            'password' => 'clave_anterior'
                
        ]);

    }

    /**
     * Pruebas de eliminación de usuario
     */

    function test_deletes_a_user ()
    {
        $user = User::factory()->create();

        $this->delete("/usuarios/{$user->id}")
            ->assertRedirect("/usuarios");

        $this->assertDatabaseMissing('users', [
            'id' => $user->id
        ]);

        
    }

}
