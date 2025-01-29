<?php

namespace Database\Seeders;

use App\Models\HumanResource;
use Illuminate\Database\Seeder;

class HumanResourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        HumanResource::create([
            'name'=>'admin',
            'email'=>'company@gmail.com',
            // 'phone'=>'0123456789',
            'password'=>bcrypt(12345678),
            'image'=>'public/admin/assets/images/users/admin.png',
        ]);
    }
}
