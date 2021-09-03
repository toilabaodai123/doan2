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
			$table->unsignedbiginteger('stocker_id')->nullable();
			$table->unsignedbiginteger('accountant_id')->nullable();
			$table->unsignedbiginteger('supplier_id');
			$table->string('note')->nullable();
			$table->string('note_stocker')->nullable();
			$table->string('note_accountant')->nullable();			
			$table->biginteger('total')->nullable();
            $table->timestamps();

			$table->foreign('supplier_id')->references('id')->on('suppliers');
			$table->foreign('accountant_id')->references('id')->on('users');				
			$table->foreign('stocker_id')->references('id')->on('users');
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
