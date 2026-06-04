<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('production_counts', function (Blueprint $table): void {
            $table->id();
            $table->string('camera_id', 50);
            $table->dateTime('counted_at');
            $table->unsignedInteger('count_value')->default(0);
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->index('camera_id');
            $table->index('counted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('production_counts');
    }
};
