<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('company_profiles', function (Blueprint $table) {
            $table->string('about_image_1')->nullable()->after('logo');
            $table->string('about_image_2')->nullable()->after('about_image_1');
            $table->string('about_image_3')->nullable()->after('about_image_2');
        });
    }

    public function down(): void
    {
        Schema::table('company_profiles', function (Blueprint $table) {
            $table->dropColumn(['about_image_1', 'about_image_2', 'about_image_3']);
        });
    }
};
