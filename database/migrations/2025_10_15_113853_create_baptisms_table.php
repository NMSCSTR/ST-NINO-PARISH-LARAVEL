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
        Schema::create('baptisms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('set null')->nullable();
            $table->date('baptism_date');
            $table->string('name_of_father')->nullable();
            $table->string('name_of_mother')->nullable();
            $table->string('baptized_by')->nullable();
            $table->string('place')->nullable();
            $table->string('godfather')->nullable();
            $table->string('godmother')->nullable();
            $table->string('witnesses')->nullable(); //atleast more witnesses
            $table->foreignId('issued_by')->constrained()->onDelete('set null')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('baptisms');
    }
};
