<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use \App\Models\User;
use \App\Models\Profession;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $professionId = Profession::where('title', 'Desarrollador back-end')->value('id');

        $user = User::factory()->create([
            'name' => 'Pepe Benavente',
            'email' => 'pepebenavente@hotmail.es',
            'password' => bcrypt('elmejorcantante'),
            'profession_id' => $professionId,
        ]);

        $user->assignRole('Administrador');

        $user = User::factory()->create([
            'name' => 'Damon García',
            'email' => 'correoprueba@hotmail.es',
            'profession_id' => 2,
            'password' => bcrypt('prueba'),
        ]);

        $user->assignRole('Usuario registrado');

        User::factory(48)->create();
    }
}
