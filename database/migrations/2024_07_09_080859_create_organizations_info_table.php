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
        Schema::create('organizations_info', function (Blueprint $table) {
            $table->id('org_id');
            $table->string('org_email')->unique();
            $table->string('org_name')->unique();
            $table->string('org_type');
            $table->text('description');
            $table->string('country');
            $table->string('city');
            $table->string('address');
            $table->string('zipcode');
            $table->string('operating_hour');
            $table->string('contact_info');
            $table->text('image')->nullable();
            $table->timestamps();
        });

        Schema::table('organizations_info', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
