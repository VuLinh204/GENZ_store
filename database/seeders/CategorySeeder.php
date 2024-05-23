<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            [
                'name' => 'Quần',
                'parent_id' => '0',
                'image' => 'logoquan.png',
                'description' => 'Các loại quần',
                'slug' => '',
            ],
            [
                'name' => 'Áo',
                'parent_id' => '0',
                'image' => 'logoao.png',
                'description' => 'Các loại áo',
                'slug' => '',
            ],
            [
                'name' => 'Giày & dép',
                'parent_id' => '0',
                'image' => 'logogiay.png',
                'description' => 'tất cả giày & dép',
                'slug' => '',
            ],
            [
                'name' => 'Áo khoác',
                'parent_id' => '0',
                'image' => 'logoaokhoac.png',
                'description' => 'Các loại áo khoác',
                'slug' => '',
            ],
            [
                'name' => 'Phụ kiện & trang sức',
                'parent_id' => '0',
                'image' => 'logophukien.png',
                'description' => 'Các loại nón',
                'slug' => '',
            ],
        ]);
    }
}
