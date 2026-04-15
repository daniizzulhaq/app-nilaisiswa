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
        Schema::create('kkm', function (Blueprint $table) {
    $table->id();
    $table->foreignId('mata_pelajaran_id')->constrained('mata_pelajaran')->onDelete('cascade');
    $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');
    $table->integer('nilai_kkm')->default(75);
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kkm');
    }
};
