<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sub_indicator_id')->constrained()->cascadeOnDelete();
            $table->integer('semester'); // 1 atau 2
            $table->enum('scale', ['BB', 'MB', 'BSH', 'BSB']);
            $table->timestamps();
            
            // Mencegah duplikasi nilai untuk indikator yang sama di semester yang sama
            $table->unique(['student_id', 'sub_indicator_id', 'semester']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('scores');
    }
};