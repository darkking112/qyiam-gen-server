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
        Schema::create('sheets', function (Blueprint $table) {
            $table->id("sheetID");
            $table->unsignedBigInteger("studentID");
            $table->integer("prayerOnTime");
            $table->integer("voluntaryPrayers");
            $table->integer("morningSupplications");
            $table->integer("eveningSupplications");
            $table->integer("quranDailyPortion");
            $table->integer("listeningToParents");
            $table->integer("organizingPersonalBelongings");
            $table->integer("siwak");
            $table->integer("helpingInHouse");
            $table->integer("sleepingEarly");
            $table->integer("lessonsReviewing");
            $table->integer("readingSurahAlKahaf");
            $table->integer("attendingFridayEarly");
            $table->integer("connectingWithRelatives");
            $table->integer("dailyExercise");
            $table->integer("healthyFood");
            $table->string("insertedBy")->default("Parents");
            $table->string("date");
            $table->timestamps();

            $table->foreign('studentID')->references('studentID')->on('students')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sheets');
    }
};
