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

        //$professions = DB::select('SELECT id FROM professions WHERE title = ? LIMIT 0,1', ['Desarrollador back-end']);

        //$profession = DB::table('professions')->select('id')->first();
        $professionId = Profession::where('title', 'Desarrollador back-end')->value('id');

        User::create([
            'name' => 'Pepe Benavente',
            'email' => 'pepebenavente@hotmail.es',
            'password' => bcrypt('elmejorcantante'),
            'profession_id' => $professionId,
            'is_admin' => true,
        ]);

        User::create([
            'name' => 'Paco Sanz',
            'email' => 'pacosanz@hotmail.es',
            'password' => bcrypt('elmejorcantante'),
            'profession_id' => $professionId,
        ]);

        User::create([
            'name' => 'Will Smith',
            'email' => 'willsmith@hotmail.com',
            'password' => bcrypt('elmejorcantante'),
            'profession_id' => null,
        ]);
    }
}
