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
        Schema::create('donation_history', function (Blueprint $table) {
            $table->id('donationhistory_id');
            $table->integer('units');
            $table->string('component');
            $table->date('donation_date');
            $table->timestamps();
        });

        Schema::table('donation_history', function (Blueprint $table) {
            $table->unsignedBigInteger('donor_id')->nullable();
            $table->foreign('donor_id')->references('donor_id')->on('donors');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donation_history');
    }
};
