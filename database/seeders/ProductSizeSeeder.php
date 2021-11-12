<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductSize;

class ProductSizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$array = ['S','M','L','XL','XXL'];
		foreach($array as $size){
			$Size = new ProductSize();
			$Size->sizeName = $size;
			$Size->save();
		}
    }
}
