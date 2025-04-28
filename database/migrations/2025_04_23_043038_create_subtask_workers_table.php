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
        Schema::create('subtask_workers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('subtask_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['pending', 'in_progress', 'in_review', 'done', 'rejected']);
            $table->string('image')->nullable();
            $table->string('comment')->nullable();
            $table->string('information')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subtask_workers');
    }
};
