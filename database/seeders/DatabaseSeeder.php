<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        
        $this->truncateTables([
            'users',
            'professions',
            'roles',
            'permissions'
        ]);
        
        $this->call(ProfessionSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(CompanySeeder::class);
        $this->call(DepartmentSeeder::class);
        $this->call(UserSeeder::class);
    }

    protected function truncateTables(array $tables)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        
        foreach ($tables as $table){
            DB::table($table)->truncate();
        }

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }


}
