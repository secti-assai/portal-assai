<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::table('eventos')
            ->where('status', 'adiado')
            ->update([
                'status' => 'confirmado',
                'updated_at' => now(),
            ]);
    }

    public function down(): void
    {
    }
};
