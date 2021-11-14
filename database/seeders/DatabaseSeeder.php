<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaymentMethod;
use App\Models\AdminSetting;
use App\Models\ProductSize;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {	
        $Settings = new AdminSetting();
		$Settings->is_maintenance = 0;
		$Settings->is_outofservice = 0;
		$Settings->save();
		
		$Methods =['COD','Chuyển khoản'];
		foreach($Methods as $method){
			$Method = new PaymentMethod();
			$Method->method_name = $method;
			$Method->status = 0;
			$Method->save();
		}		
		
		$Sizes = ['S','M','L','XL','XXL'];
		foreach($Sizes as $size){
			$Size = new ProductSize();
			$Size->sizeName = $size;
			$Size->save();
		}		
    }
}
