<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Psy\Readline\Hoa\Console;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Lấy danh sách khách hàng từ bảng 'customers'
        $customers = Customer::all();

        // Duyệt qua mỗi khách hàng và tạo người dùng tương ứng trong bảng 'users'
        foreach ($customers as $customer) {
            // Tạo một người dùng mới
            $user = new User();

            // Gán thông tin từ khách hàng vào người dùng
            $user->role = $customer->role;
            $user->email = $customer->email;
            $user->image = $customer->image;
            $user->password = bcrypt($customer->password);
            $user->customer_id = $customer->id;
            $user->name = $customer->name;
            $user->save();
        }
    }
}
