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
			$table->string('orderCode')->nullable();
			$table->unsignedbiginteger('user_id')->nullable();
			$table->unsignedbiginteger('admin_id')->nullable();
			$table->integer('orderStatus_id')->default(1);
			$table->string('fullName');
			$table->integer('phone');
			$table->string('address');
			$table->string('email')->nullable();
			$table->string('userNote')->nullable();
			$table->string('adminNote')->nullable();
			$table->dateTime('orderDate');
			$table->integer('orderTotal');
			$table->integer('status')->default(1);
            $table->timestamps();
			
			$table->foreign('user_id')->references('id')->on('users');
			$table->foreign('admin_id')->references('id')->on('users');
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
