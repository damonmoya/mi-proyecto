<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission = Permission::create(['name' => 'Crear usuarios']);
        $permission = Permission::create(['name' => 'Editar usuarios']);
        $permission = Permission::create(['name' => 'Eliminar usuarios']);
    }
}
