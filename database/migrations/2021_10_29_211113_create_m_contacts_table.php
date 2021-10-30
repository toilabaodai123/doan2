<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_contacts', function (Blueprint $table) {
            $table->id();
            $table->string('iframe');
            $table->string('sub_title');
            $table->string('contact');
            $table->string('contact_des');
            $table->string('diadiem');
            $table->string('diadiem_des');
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
        Schema::dropIfExists('m_contacts');
    }
}
