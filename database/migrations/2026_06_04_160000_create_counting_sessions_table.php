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
        Schema::create('counting_sessions', function (Blueprint $table): void {
            $table->id();
            $table->string('device_id', 100)->unique();
            $table->string('source_id', 255)->nullable();
            $table->unsignedInteger('current_count')->default(0);
            $table->enum('status', ['started', 'running', 'stopped', 'disconnected'])->default('stopped');
            $table->float('fps')->nullable();
            $table->dateTime('last_heartbeat_at')->nullable();
            $table->dateTime('session_started_at')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->index('status');
            $table->index('last_heartbeat_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('counting_sessions');
    }
};
