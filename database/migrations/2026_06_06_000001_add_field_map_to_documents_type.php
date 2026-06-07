<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() !== 'sqlite') {
            DB::statement("ALTER TABLE documents MODIFY COLUMN type ENUM('contract', 'technical_drawing', 'bast', 'material_report', 'field_map', 'other')");
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() !== 'sqlite') {
            DB::statement("ALTER TABLE documents MODIFY COLUMN type ENUM('contract', 'technical_drawing', 'bast', 'material_report', 'other')");
        }
    }
};
