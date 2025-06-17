<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNotificationFlagsToHumanResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('human_resources', function (Blueprint $table) {
            $table->boolean('cnic_notified')->default(false);
            $table->boolean('passport_notified')->default(false);
            $table->boolean('visa_notified')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('human_resources', function (Blueprint $table) {
                    $table->dropColumn(['cnic_notified', 'passport_notified', 'visa_notified']);

        });
    }
}
