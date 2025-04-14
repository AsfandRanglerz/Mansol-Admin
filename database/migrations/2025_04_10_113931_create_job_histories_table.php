<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('human_resource_id')->constrained(`human_resources`)->onDelete('cascade');
            $table->string('company_name')->nullable(); 
            $table->string('craft_name')->nullable(); 
            $table->string('sub_craft_name')->nullable(); 
            $table->string('start_date')->nullable(); 
            $table->string('end_date')->nullable(); 
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
        Schema::dropIfExists('job_histories');
    }
}
