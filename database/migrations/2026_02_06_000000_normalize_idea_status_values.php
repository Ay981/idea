<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('ideas')
            ->whereIn('status', ['in_progress', 'Inprogress'])
            ->update(['status' => 'inprogress']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert 'inprogress' back to 'in_progress' for entries updated by this migration.
        DB::table('ideas')
            ->where('status', 'inprogress')
            ->update(['status' => 'in_progress']);
    }
};
