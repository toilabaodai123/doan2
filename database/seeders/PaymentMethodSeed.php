<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaymentMethod;

class PaymentMethodSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$Methods =['COD','Chuyển khoản'];
		foreach($Methods as $method){
			$Method = new PaymentMethod();
			$Method->method_name = $method;
			$Method->status = 0;
			$Method->save();
		}
    }
}
