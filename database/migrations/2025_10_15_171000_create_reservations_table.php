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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained()->onDelete('cascade');
            $table->foreignId('sacrament_id')->constrained()->onDelete('cascade');
            $table->decimal('fee', 8, 2)->nullable();

            // Updated status enum
            $table->enum('status', ['pending', 'forwarded_to_priest', 'approved', 'rejected'])->default('pending');

            $table->unsignedBigInteger('forwarded_by')->nullable()->after('status');
            $table->timestamp('forwarded_at')->nullable()->after('forwarded_by');
            $table->foreign('forwarded_by')->references('id')->on('users')->nullOnDelete();

            $table->dateTime('reservation_date')->nullable();
            $table->text('remarks')->nullable();

            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
