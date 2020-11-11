<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create(['name' => 'Administrador']);
        $role->givePermissionTo('Crear usuarios');
        $role->givePermissionTo('Editar usuarios');
        $role->givePermissionTo('Eliminar usuarios');
        $role->givePermissionTo('Crear empresa');
        $role->givePermissionTo('Editar empresa');
        $role->givePermissionTo('Eliminar empresa');
        $role->givePermissionTo('Crear departamento');
        $role->givePermissionTo('Editar departamento');
        $role->givePermissionTo('Eliminar departamento');

        $role = Role::create(['name' => 'Usuario registrado']);
    }
}
