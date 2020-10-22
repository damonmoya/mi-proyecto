<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
        $professionId = DB::table('professions')
        ->where('title', 'Desarrollador back-end')
        ->value('id');

        DB::table('users')->insert([
            'name' => 'Pepe Benavente',
            'email' => 'penebenavente@hotmail.es',
            'password' => bcrypt('elmejorcantante'),
            'profession_id' => $professionId,
        ]);
    }
}
