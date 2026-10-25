<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('description_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aspect_id')->constrained()->cascadeOnDelete();
            $table->enum('scale', ['BB', 'MB', 'BSH', 'BSB']);
            $table->text('template_text');
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('description_templates');
    }
};