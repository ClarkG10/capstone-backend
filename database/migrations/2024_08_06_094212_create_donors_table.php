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
            $table->string('fullname');
            $table->date('birthday');
            $table->string('gender');
            $table->integer('age');
            $table->text('address');
            $table->string('email');
            $table->integer('phonenumber');
            $table->string('blood_type');
            $table->text('medical_history')->nullable();
            $table->text('current_medications')->nullable();
            $table->text('allergies')->nullable();
            $table->text('previous_donation');
            $table->string('emergency_name');
            $table->string('emergency_relationship');
            $table->integer('emergency_phonenumber');
            $table->string('status')->default('Active');
            $table->timestamps();
        });

        Schema::table('donors', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
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
