<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttributesProduct extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('attributes_products')->insert([
            [
                'name' => 'color',
                'value' => 'white',               
            ],
            [
                'name' => 'color',
                'value' => 'black',               
            ],
            [
                'name' => 'size',
                'value' => 'M',               
            ],
            [
                'name' => 'size',
                'value' => 'L',               
            ],
        ]);
    }
}
