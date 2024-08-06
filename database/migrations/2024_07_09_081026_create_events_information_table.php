<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('events_information', function (Blueprint $table) {
            $table->id('event_id');
            $table->string('event_name');
            $table->string('event_location');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('time_start');
            $table->string('time_end');
            $table->string('description');
            $table->string('gender');
            $table->string('weight');
            $table->integer('min_age');
            $table->integer('max_age');
            $table->string('contact_info');
            $table->string('status');
            $table->integer('participants')->default("0");
            $table->timestamps();
        });


        Schema::table('events_information', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events_information');
    }
};
