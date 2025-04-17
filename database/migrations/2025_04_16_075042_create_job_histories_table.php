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

        $table->unsignedBigInteger('human_resource_id')->nullable();
        $table->unsignedBigInteger('company_id')->nullable();
        $table->unsignedBigInteger('project_id')->nullable();
        $table->unsignedBigInteger('demand_id')->nullable();
        $table->unsignedBigInteger('craft_id')->nullable();
        $table->unsignedBigInteger('sub_craft_id')->nullable();

        $table->string('application_date')->nullable();
        $table->string('demobe_date')->nullable();
        $table->string('status')->default(0);

        $table->timestamps();

        // Foreign Keys
        $table->foreign('human_resource_id')->references('id')->on('human_resources')->onDelete('cascade');
        $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        $table->foreign('demand_id')->references('id')->on('demands')->onDelete('cascade');
        $table->foreign('craft_id')->references('id')->on('main_crafts')->onDelete('cascade');
        $table->foreign('sub_craft_id')->references('id')->on('sub_crafts')->onDelete('cascade');
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
