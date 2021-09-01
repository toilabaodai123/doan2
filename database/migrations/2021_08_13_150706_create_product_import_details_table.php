<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductImportDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_import_details', function (Blueprint $table) {
            $table->id();
			$table->unsignedBiginteger('import_bill_id');
			$table->foreign('import_bill_id')->references('id')->on('product_import_bills');
			$table->unsignedBiginteger('product_model_id');
			$table->foreign('product_model_id')->references('id')->on('product_models');

			$table->integer('amount');
			$table->biginteger('price');
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
        Schema::dropIfExists('product_import_details');
    }
}
