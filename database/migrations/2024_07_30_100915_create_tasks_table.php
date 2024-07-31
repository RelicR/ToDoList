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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('task')->nullable(false);
            $table->string('description')->nullable(true);
            $table->boolean('is_urgent')->default(false);
            $table->timestamp('task_create')->nullable(false);
            $table->timestamp('task_done')->nullable(true);
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
