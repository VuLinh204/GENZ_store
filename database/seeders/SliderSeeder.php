<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sliders')->insert([
            [
                'name' => 'Ưu Đãi Đặc Biệt: Giảm Giá Đến 50%',
                'description' => 'Đừng bỏ lỡ cơ hội sở hữu những món đồ thời trang yêu thích với mức giá siêu ưu đãi. Giảm giá đến 50% cho các sản phẩm hot nhất mùa này. Mua sắm ngay hôm nay!',
                'img_path' => "assets/img/",
                'img_name' => 'banner4.jpg',
            ],
            [
                'name' => 'Phụ Kiện Thời Trang Hot Nhất',
                'description' => 'Hoàn thiện bộ trang phục của bạn với các phụ kiện thời trang hot nhất',
                'img_path' => "assets/img/",
                'img_name' => 'banner3.jpg',
            ],
            [
                'name' => 'Thời Trang Công Sở Thanh Lịch',
                'description' => 'Các loại áo',
                'img_path' => "assets/img/",
                'img_name' => 'banner1.jpg',
            ],
            [
                'name' => ' Phong Cách Thời Thượng Mùa Thu',
                'description' => 'Các loại áo',
                'img_path' => "assets/img/",
                'img_name' => 'banner7.jpg',
            ],
        ]);
    }
}
