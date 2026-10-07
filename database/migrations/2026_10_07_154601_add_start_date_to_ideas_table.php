<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ideas', function (Blueprint $table) {
            // Adiciona o campo start_date após a coluna status (ou após description)
            $table->string('start_date')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('ideas', function (Blueprint $table) {
            $table->dropColumn('start_date');
        });
    }
};
