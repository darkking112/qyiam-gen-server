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
        Schema::create('comments', function (Blueprint $table) {
            $table->id("commentID");
            $table->unsignedBigInteger("studentID");
            $table->unsignedBigInteger("teacherID")->nullable(true);
            $table->text("comment");
            $table->string("commentType")->default("Positive");
            $table->string("date");
            $table->timestamps();

            $table->foreign('studentID')->references('studentID')->on('students')->onDelete('cascade');
            $table->foreign('teacherID')->references('teacherID')->on('teachers')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
