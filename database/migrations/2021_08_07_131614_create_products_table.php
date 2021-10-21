<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
			$table->string('productName')->nullable();
			$table->string('productSlug');
			$table->biginteger('CategoryID')->nullable();
			$table->biginteger('CategoryID2')->nullable();
			$table->biginteger('supplierID');
			$table->integer('productPrice')->nullable();
			$table->string('shortDesc')->nullable();
			$table->string('longDesc')->nullable();
			$table->integer('status')->default(2);
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
        Schema::dropIfExists('products');
    }
}
