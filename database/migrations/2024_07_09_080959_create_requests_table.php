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
        Schema::create('requests', function (Blueprint $table) {
            $table->id('request_id');
            $table->string('blood_type');
            $table->string('component');
            $table->string('urgency_scale');
            $table->integer('quantity');
            $table->string('status');
            $table->timestamps();
        });

        Schema::table('requests', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::table('requests', function (Blueprint $table) {
            $table->unsignedBigInteger('receiver_id')->nullable();
            $table->foreign('receiver_id')->references('org_id')->on('organizations_info');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};
