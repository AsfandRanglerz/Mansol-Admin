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
            $table->foreignId('company_id')->constrained(`companies`)->onDelete('cascade')->nullable(); 
            $table->foreignId('project_id')->constrained(`projects`)->onDelete('cascade')->nullable(); 
            $table->foreignId('demand_id')->constrained(`demands`)->onDelete('cascade')->nullable(); 
            $table->foreignId('craft_id')->constrained(`main_crafts`)->onDelete('cascade')->nullable(); 
            $table->foreignId('sub_craft_id')->constrained(`sub_crafts`)->onDelete('cascade')->nullable(); 
            $table->string('application_date')->nullable(); 
            $table->string('demobe_date')->nullable(); 
            $table->string('status')->default(0);             $table->timestamps();
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
