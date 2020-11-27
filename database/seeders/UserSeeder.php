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

        $user->assignRole('Administrador', 'Usuario registrado');


        $professionId = Profession::where('title', 'Desarrollador Diseñador Web')->value('id');
        $departmentId = Department::where('name', 'Tecnología')->value('id');

        $user = User::factory()->create([
            'name' => 'Damon García',
            'email' => 'damon99@hotmail.es',
            'password' => bcrypt('prueba'),
            'profession_id' => $professionId,
            'department_id' => $departmentId,
            
        ])->assignRole('Usuario registrado');

        $professionId = Profession::where('title', 'Desarrollador Diseñador Web')->value('id');
        $departmentId = Department::where('name', 'Tecnología')->value('id');

        $user = User::factory()->create([
            'name' => 'Ana Marina',
            'email' => 'divina_ana98@hotmail.com',
            'password' => bcrypt('prueba'),
            'profession_id' => $professionId,
            'department_id' => $departmentId,
            
        ])->assignRole('Usuario registrado');

        $professionId = Profession::where('title', 'Desarrollador Diseñador Web')->value('id');
        $departmentId = Department::where('name', 'Mantenimiento')->value('id');

        $user = User::factory()->create([
            'profession_id' => $professionId,
            'department_id' => $departmentId,
            
        ])->assignRole('Usuario registrado');

        $randomUser = User::factory(8)->create([
            'profession_id' => $professionId,
            'department_id' => $departmentId,
        ]);
        foreach($randomUser as $user){
            $user->assignRole('Usuario registrado');
         }
    }
}
