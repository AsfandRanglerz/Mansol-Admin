<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('hr_steps', function (Blueprint $table) {
           $table->enum('received_physically', ['Yes', 'No'])->default('No');
            // replace existing_column_name with the column after which you want to add
        });
    }

    public function down()
    {
        Schema::table('hr_steps', function (Blueprint $table) {
            $table->dropColumn('received_physically');
        });
    }
};
