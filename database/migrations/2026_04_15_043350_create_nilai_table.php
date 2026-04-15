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
        Schema::create('nilai', function (Blueprint $table) {
    $table->id();
    $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');
    $table->foreignId('mata_pelajaran_id')->constrained('mata_pelajaran')->onDelete('cascade');
    $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');
    $table->string('semester');
    $table->string('tahun_ajaran');
    $table->decimal('nilai_tugas', 5, 2)->nullable();
    $table->decimal('nilai_uts', 5, 2)->nullable();
    $table->decimal('nilai_uas', 5, 2)->nullable();
    $table->decimal('nilai_sikap', 5, 2)->nullable();
    $table->decimal('nilai_akhir', 5, 2)->nullable();
    $table->string('predikat')->nullable(); // A, B, C, D
    $table->boolean('lulus')->default(false);
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai');
    }
};
