<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImportDuplicateCnicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('import_duplicate_cnics', function (Blueprint $table) {
            $table->id();
            $table->string('file_name');
            $table->string('cnic');
            $table->integer('count');
            $table->json('rows')->nullable();
            $table->json('seen')->default(0);
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
        Schema::dropIfExists('import_duplicate_cnics');
    }
}
