<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNominatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nominates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('craft_id')->constrained('main_crafts')->cascadeOnUpdate();
            $table->foreignId('human_resource_id')->constrained('human_resources')->cascadeOnUpdate();
            $table->foreignId('demand_id')->constrained('demands')->cascadeOnUpdate();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnUpdate();
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
        Schema::dropIfExists('nominates');
    }
}
