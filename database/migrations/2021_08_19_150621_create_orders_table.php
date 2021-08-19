<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id()->from(10000);
			$table->string('orderCode');
			$table->biginteger('user_id')->nullable();
			$table->biginteger('orderStatus_id')->default(1);
			$table->string('fullName');
			$table->string('email')->nullable();
			$table->string('phone');
			$table->string('userNote')->nullable();
			$table->string('adminNote')->nullable();
			$table->integer('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
