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
        Schema::create('stock_out', function (Blueprint $table) {
            $table->id('stockOut_id');
            $table->string('blood_type');
            $table->string('rh_factor');
            $table->string('component');
            $table->integer('units_out');
            $table->timestamps();
        });

        Schema::table('stock_out', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::table('stock_out', function (Blueprint $table) {
            $table->unsignedBigInteger('inventory_id')->nullable();
            $table->foreign('inventory_id')->references('inventory_id')->on('inventory');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_out');
    }
};
