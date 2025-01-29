<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubCraftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_crafts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('craft_id')->nullable();
            $table->foreign('craft_id')->references('id')->on('main_crafts')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('status')->default(1);
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
        Schema::dropIfExists('sub_crafts');
    }
}
