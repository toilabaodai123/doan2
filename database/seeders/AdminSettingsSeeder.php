<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AdminSetting;

class AdminSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Settings = new AdminSetting();
		$Settings->is_maintanance = 0;
		$Settings->is_outofservice = 0;
		$Settings->save();
    }
}
