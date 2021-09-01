<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductImportBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_import_bills', function (Blueprint $table) {
            $table->id();
			$table->unsignedBiginteger('user_id');
			$table->foreign('user_id')->references('id')->on('users');
			$table->datetime('bill_date');
			$table->string('bill_code')->nullable();
			$table->integer('VAT');
			$table->integer('status');
			$table->unsignedbiginteger('approved_id')->nullable();
			$table->foreign('approved_id')->references('id')->on('users');
			$table->datetime('approved_date')->nullable();
			$table->string('note')->nullable();
			$table->string('note_admin')->nullable();
			$table->biginteger('total')->nullable();
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
        Schema::dropIfExists('product_import_bills');
    }
}
