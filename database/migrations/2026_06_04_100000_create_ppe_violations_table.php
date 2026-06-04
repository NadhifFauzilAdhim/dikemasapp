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
        Schema::create('ppe_violations', function (Blueprint $table): void {
            $table->id();
            $table->dateTime('detected_at');
            $table->string('camera_id', 50);
            $table->string('violation_type', 30);
            $table->unsignedTinyInteger('violation_class_id');
            $table->float('confidence');
            $table->json('bbox');
            $table->unsignedInteger('person_count')->default(0);
            $table->json('all_detections')->nullable();
            $table->unsignedInteger('frame_id')->nullable();
            $table->float('inference_time_ms')->nullable();
            $table->string('image_path');
            $table->json('raw_payload');
            $table->timestamps();

            $table->index('detected_at');
            $table->index('camera_id');
            $table->index('violation_type');
            $table->index('violation_class_id');
            $table->index('created_at');
            $table->index(['violation_type', 'detected_at']);
            $table->index(['camera_id', 'detected_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ppe_violations');
    }
};
