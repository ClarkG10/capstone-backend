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
        Schema::create('donors', function (Blueprint $table) {
            $table->id('donor_id');
            $table->string('email')->unique()->nullable();
            $table->string('password')->nullable();
            $table->string('fullname')->nullable();
            $table->date('birthday')->nullable();
            $table->string('gender')->nullable();
            $table->integer('age')->nullable();
            $table->text('address')->nullable();
            $table->string('email_address')->nullable();
            $table->integer('phonenumber')->nullable();
            $table->string('blood_type')->nullable();
            $table->text('medical_history')->nullable();
            $table->text('current_medications')->nullable();
            $table->text('allergies')->nullable();
            $table->text('previous_donation')->nullable();
            $table->string('emergency_name')->nullable();
            $table->string('emergency_relationship')->nullable();
            $table->integer('emergency_phonenumber')->nullable();
            $table->string('status')->default('Active');
            $table->timestamps();
        });

        Schema::table('donors', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donors');
    }
};
