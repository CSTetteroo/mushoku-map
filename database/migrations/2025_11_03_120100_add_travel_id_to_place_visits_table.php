<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('place_visits', function (Blueprint $table) {
            $table->foreignId('travel_id')->nullable()->constrained('travels')->nullOnDelete();
        });
    }

    public function down(): void {
        Schema::table('place_visits', function (Blueprint $table) {
            $table->dropConstrainedForeignId('travel_id');
        });
    }
};
