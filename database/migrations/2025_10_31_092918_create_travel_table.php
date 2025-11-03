<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('travels', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('type')->nullable(); // e.g., "Carriage", "Ship"
            $table->string('color')->default('red');
            $table->text('reason')->nullable();
            $table->json('path'); // [[y,x], [y,x], ...]
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('travels');
    }
};
