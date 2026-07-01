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
        Schema::create('wilayah', function (Blueprint $table) {
             $table->id();

        $table->foreignId('induk_id')
            ->nullable()
            ->constrained('wilayah')
            ->restrictOnDelete()
            ->cascadeOnUpdate();

        $table->string('nama',100);

        $table->enum('level',[
            'kota_kabupaten',
            'kecamatan',
            'kelurahan'
        ]);

        $table->string('kode_bps',20)
            ->nullable()
            ->unique();

        $table->decimal('latitude',10,7)
            ->nullable();

        $table->decimal('longitude',10,7)
            ->nullable();

        $table->boolean('aktif')
            ->default(true);

        $table->timestamps();

        $table->index('induk_id');
        $table->index('level');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wilayah');
    }
};
