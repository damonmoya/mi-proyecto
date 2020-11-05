<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use \App\Models\Company;
use \App\Models\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $companyId = Company::where('name', 'Mejores Cantantes S.L.')->value('id');

        $department = Department::factory()->create([
            'name' => 'Recursos Humanos',
            'company_id' => $companyId,
        ]);

        $companyId = Company::where('name', 'Mejores Cantantes S.L.')->value('id');
        $dependentId = Department::where('name', 'Recursos Humanos')->value('id');

        $department = Department::factory()->create([
            'name' => 'Selección',
            'dependent_id' => $dependentId,
            'company_id' => $companyId,
        ]);

        $companyId = Company::where('name', 'Digital Art & Designers')->value('id');

        $department = Department::factory()->create([
            'name' => 'Producción',
            'company_id' => $companyId,
        ]);

        $companyId = Company::where('name', 'Digital Art & Designers')->value('id');
        $dependentId = Department::where('name', 'Producción')->value('id');

        $department = Department::factory()->create([
            'name' => 'Tecnología',
            'dependent_id' => $dependentId,
            'company_id' => $companyId,
        ]);

        $companyId = Company::where('name', 'Digital Art & Designers')->value('id');
        $dependentId = Department::where('name', 'Producción')->value('id');

        $department = Department::factory()->create([
            'name' => 'Mantemiento',
            'dependent_id' => $dependentId,
            'company_id' => $companyId,
        ]);

        

        

        
    }
}
