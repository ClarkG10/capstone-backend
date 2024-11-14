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
        Schema::create('reserve_blood', function (Blueprint $table) {
            $table->id('reserveBlood_id');
            $table->string('blood_type');
            $table->string('rh_factor');
            $table->string('component');
            $table->string('avail_blood_units');
            $table->timestamps();
        });

        Schema::table('reserve_blood', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reserve_blood');
    }
};
