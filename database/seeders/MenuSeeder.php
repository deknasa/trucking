<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menu')->insert([

            'menuname' => 'Home',

            'menuseq' => 10,

            'menuparent' => 0,

            'menuicon' => 'icon-home',

            'aco_id' => 0,
            
            'modifiedby' => 'admin',

            'link' => '',

            'menuexe' => 'dashboard',

            'menukode' => 0

        ]);
    }
}
