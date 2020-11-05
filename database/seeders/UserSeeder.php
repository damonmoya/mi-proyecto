<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use \App\Models\User;
use \App\Models\Profession;
use \App\Models\Department;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $professionId = Profession::where('title', 'Empleador')->value('id');
        $departmentId = Department::where('name', 'Selección')->value('id');

        $user = User::factory()->create([
            'name' => 'Pepe Benavente',
            'email' => 'pepebenavente@hotmail.es',
            'password' => bcrypt('elmejorcantante'),
            'profession_id' => $professionId,
            'department_id' => $departmentId,
        ]);

        $user->assignRole('Administrador');


        $professionId = Profession::where('title', 'Desarrollador Diseñador Web')->value('id');
        $departmentId = Department::where('name', 'Tecnología')->value('id');

        $user = User::factory()->create([
            'name' => 'Damon García',
            'email' => 'correoprueba@hotmail.es',
            'password' => bcrypt('prueba'),
            'profession_id' => $professionId,
            'department_id' => $departmentId,
            
        ]);

        $user->assignRole('Usuario registrado');

        User::factory(48)->create();
    }
}
