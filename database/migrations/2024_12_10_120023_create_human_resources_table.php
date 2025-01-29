<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHumanResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('human_resources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('craft_id')->nullable()
                ->constrained('main_crafts')->cascadeOnUpdate();
            $table->foreignId('sub_craft_id')->nullable()
                ->constrained('sub_crafts')->cascadeOnUpdate();
            $table->string('name')->required();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('status')->default(1);
            $table->string('image')->nullable();
            $table->string('registration')->unique();
            $table->date('application_date')->required();
            $table->string('approvals')->nullable();
            $table->string('son_of')->required();
            $table->string('mother_name')->required();
            $table->string('blood_group')->required();
            $table->date('date_of_birth')->required();
            $table->string('city_of_birth')->required();
            $table->string('cnic')->unique();
            $table->date('cnic_expiry_date')->required();
            $table->date('doi')->required();
            $table->date('doe')->required();
            $table->string('passport')->required()->unique();
            $table->string('passport_issue_place')->required();
            $table->string('religion')->required();
            $table->string('experience')->nullable();
            $table->string('martial_status')->required();
            $table->string('next_of_kin')->required();
            $table->string('relation')->required();
            $table->string('kin_cnic')->required();
            $table->string('shoe_size')->required();
            $table->string('cover_size')->required();
            $table->string('acdemic_qualification')->required();
            $table->string('technical_qualification')->nullable();
            $table->string('profession')->required();
            $table->string('district_of_domicile')->required();
            $table->text('present_address')->required();
            $table->string('present_address_phone')->unique();
            $table->string('present_address_mobile')->unique();
            $table->string('present_address_city')->required();
            $table->text('permanent_address')->required();
            $table->string('permanent_address_phone')->unique();
            $table->string('permanent_address_mobile')->unique();
            $table->string('permanent_address_city')->required();
            $table->string('permanent_address_province')->required();
            $table->string('gender')->required();
            $table->string('citizenship')->required();
            $table->string('refference')->nullable();
            $table->string('performance_appraisal')->nullable();
            $table->string('min_salary')->required();
            $table->text('comment')->nullable();
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
        Schema::dropIfExists('human_resources');
    }
}
