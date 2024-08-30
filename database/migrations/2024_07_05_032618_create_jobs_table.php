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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->integer('professional_title_id');
            $table->integer('company_industry_id');
            $table->integer('work_type_id');
            $table->string('salary_type');
            $table->integer('salary_range_id');
            $table->string('gender');
            $table->integer('experience_level_id');
            $table->longText('job_description');
            $table->longText('job_requirement');
            $table->longText('benefit');
            $table->date('apply_expire_date');
            $table->integer('view_count')->default(0);
            $table->integer('vacancy');
            $table->string('age');
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
        Schema::dropIfExists('jobs');
    }
};
