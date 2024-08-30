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
        Schema::create('seekers', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('available_status')->default('1');
            $table->string('profile_image')->nullable();
            $table->string('gender',10)->nullable();
            $table->integer('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('martial_status',20)->nullable();
            $table->integer('professional_title_id')->nullable();
            $table->string('dob')->nullable();
            $table->string('nrc')->nullable();
            $table->string('resume')->nullable();
            $table->integer('city_id')->nullable();
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
        Schema::dropIfExists('seekers');
    }
};
