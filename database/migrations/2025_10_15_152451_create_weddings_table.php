<?php
use App\Models\User;
use App\Models\Member;

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
            $table->foreignId('husband_member_id')->nullable()->constrained('members')->onDelete('set null');
            $table->foreignId('wife_member_id')->nullable()->constrained('members')->onDelete('set null');
            $table->date('wedding_date');
            $table->date('date_issued');
            $table->string('officiating_priest')->nullable();
            $table->string('licensed_no')->nullable();
            $table->string('registration_no')->nullable();
            $table->json('witnesses')->nullable();
            $table->integer('book_no')->nullable();
            $table->integer('page')->nullable();
            $table->integer('pageno')->nullable();
            $table->year('series_start')->nullable();
            $table->year('series_end')->nullable();
            $table->foreignId('issued_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->index('wedding_date');
            $table->index('husband_member_id');
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
