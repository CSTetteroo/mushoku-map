<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('travels', function (Blueprint $table) {
            $table->foreignId('from_place_id')->nullable()->constrained('places')->nullOnDelete();
            $table->foreignId('to_place_id')->nullable()->constrained('places')->nullOnDelete();
        });
    }

    public function down(): void {
        Schema::table('travels', function (Blueprint $table) {
            $table->dropConstrainedForeignId('from_place_id');
            $table->dropConstrainedForeignId('to_place_id');
        });
    }
};
