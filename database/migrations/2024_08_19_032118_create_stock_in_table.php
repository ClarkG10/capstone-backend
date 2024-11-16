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
        Schema::create('stock_in', function (Blueprint $table) {
            $table->id('stockIn_id');
            $table->string('blood_type');
            $table->string('rh_factor');
            $table->string('component');
            $table->integer('units_in');
            $table->unsignedBigInteger('inventory_id')->nullable();
            $table->unsignedBigInteger('reserveBlood_id')->nullable();
            $table->timestamps();
        });

        Schema::table('stock_in', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_in');
    }
};
