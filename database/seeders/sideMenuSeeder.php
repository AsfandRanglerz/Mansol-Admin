<?php

namespace Database\Seeders;

use App\Models\sideMenu;
use Illuminate\Database\Seeder;

class sideMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        sideMenu::insert([
            [
                'id' => '1',
                'name' => 'Roles',
            ],
            [
                'id' => '2',
                'name' => 'Sub Admins',
            ],
            [
                'id' => '3',
                'name' => 'Main Crafts',
            ],
            [
                'id' => '4',
                'name' => 'Human Resources',
            ],
            [
                'id' => '5',
                'name' => 'Nominations',
            ],
            [
                'id' => '6',
                'name' => 'Companies',
            ],
            [
                'id' => '7',
                'name' => 'Demands',
            ],
            [
                'id' => '8',
                'name' => 'Reports',
            ],
            [
                'id' => '9',
                'name' => 'Notifications',
            ],
        ]);

    }
}
