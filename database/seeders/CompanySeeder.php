<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use \App\Models\Company;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $company = Company::factory()->create([
            'name' => 'Digital Art & Designers',
        ]);

        $company = Company::factory()->create([
            'name' => 'Mejores Cantantes S.L.',
        ]);

        Company::factory(3)->create();
    }
}
