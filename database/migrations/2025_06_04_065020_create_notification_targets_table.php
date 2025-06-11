<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationTargetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_targets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('notification_id');
            $table->unsignedBigInteger('targetable_id');
            $table->string('targetable_type');
            $table->timestamps();
             $table->foreign('notification_id')
                ->references('id')
                ->on('notifications')
                ->onDelete('cascade');

            // Optional: Add indexes for polymorphic relation
            $table->index(['targetable_type', 'targetable_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notification_targets');
    }
}
