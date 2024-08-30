<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employers', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('logo')->nullable();
            $table->string('website')->nullable();
            $table->integer('company_phone')->nullable();
            $table->integer('number_of_employees')->nullable();
            $table->string('address')->nullable();
            $table->text('company_description')->nullable();
            $table->integer('city_id')->nullable();
            $table->string('founder_name')->nullable();
            $table->string('founded_date')->nullable();
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
        Schema::dropIfExists('employers');
    }
};
