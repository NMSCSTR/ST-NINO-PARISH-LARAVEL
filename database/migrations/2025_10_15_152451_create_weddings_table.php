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
        Schema::create('weddings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('husband_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('wife_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('husband_member_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('wife_member_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weddings');
    }
};
