<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('student_descriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('aspect_id')->constrained()->cascadeOnDelete();
            $table->integer('semester');
            $table->text('final_text')->nullable();
            $table->timestamps();
            
            $table->unique(['student_id', 'aspect_id', 'semester']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('student_descriptions');
    }
};