<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('customers')->insert([
            [
                'name' => 'vulinh',
                'phone' => '0364704715',
                'address' => 'Binh Phuoc',
                'email' => 'linhlg2004@gmail.com',
                'image' => 'user1.png',
                'password' => '123456',
                'role' => 2,
            ],
            [
                'name' => 'Quang Dinh',
                'phone' => '022222222',
                'address' => 'Binh Thuan',
                'email' => 'dinhquang295@gmail.com',
                'image' => 'dinhdt.jpg',
                'password' => '123456',
                'role' => 1,
            ],
            [
                'name' => 'Nhat Tuan',
                'phone' => '0333333333',
                'address' => 'Sai Gon',
                'email' => 'Tuannhat124@gmail.com',
                'image' => 'user3.png',
                'password' => '1234567',
                'role' => 1,

            ],
            [
                'name' => 'Vũ Linh',
                'phone' => '0364704715',
                'address' => 'Binh Phuoc',
                'email' => 'linhlg042004@gmail.com',
                'image' => 'user1.png',
                'password' => '123456',
                'role' => 1,
            ],
        ]);
    }
}
