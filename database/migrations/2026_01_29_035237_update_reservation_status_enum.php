<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Using raw SQL to modify the ENUM list safely
        DB::statement("ALTER TABLE reservations MODIFY COLUMN status ENUM('pending', 'forwarded_to_priest', 'approved', 'rejected', 'cancelled') DEFAULT 'pending'");
    }

    public function down(): void
    {
        // Revert back to the original list (Note: any 'cancelled' rows will cause a warning)
        DB::statement("ALTER TABLE reservations MODIFY COLUMN status ENUM('pending', 'forwarded_to_priest', 'approved', 'rejected') DEFAULT 'pending'");
    }
};
