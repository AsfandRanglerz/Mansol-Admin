<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            $table->unsignedBigInteger('draft_id')->nullable();
            $table->string('is_ongoing')->default('unchecked');
            $table->string('is_active')->default(1);
            $table->string('project_code');
            $table->string('project_name');
            $table->string('project_currency');
            $table->string('project_location');
            $table->string('manpower_location');
            $table->date('project_start_date');
            $table->date('project_end_date')->nullable();
            $table->string('permission')->nullable();
            $table->date('permission_date')->nullable();
            $table->string('poa_received')->default('unchecked');
            $table->string('demand_letter_received')->default('unchecked');
            $table->string('permission_letter_received')->default('unchecked');
            $table->text('additional_notes')->nullable();
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
        Schema::dropIfExists('projects');
    }
}
