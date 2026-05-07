<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $blueprint) {
       
            $blueprint->decimal('latitude', 10, 8)->nullable()->after('location');
            $blueprint->decimal('longitude', 11, 8)->nullable()->after('latitude');
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $blueprint) {
            $blueprint->dropColumn(['latitude', 'longitude']);
        });
    }
};