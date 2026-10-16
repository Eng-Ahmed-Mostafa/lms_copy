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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['multiple_choice', 'true_false', 'short_answer']);
            $table->longText('question_text');
            $table->longText('explanation')->nullable();
            $table->decimal('points', 8, 2)->default(1);
            $table->enum('difficulty', ['easy', 'medium', 'hard'])->default('easy');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['draft', 'active', 'inactive', 'archived'])->default('draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
