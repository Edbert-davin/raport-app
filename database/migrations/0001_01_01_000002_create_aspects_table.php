<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('aspects', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., Nilai Agama dan Moral
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('aspects');
    }
};