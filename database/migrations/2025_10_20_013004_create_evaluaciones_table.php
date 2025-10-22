<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('evaluaciones', function (Blueprint $table) {
            $table->id();

            $table->foreignId('medida_id')->constrained('medidas')->cascadeOnDelete();
            $table->foreignId('oms_ref_id')->constrained('oms_ref')->restrictOnDelete();
            $table->foreignId('frisancho_ref_id')->constrained('frisancho_ref')->restrictOnDelete();

            // Derivados
            $table->decimal('imc', 5, 2);
            $table->decimal('peso_ideal', 6, 2)->nullable();
            $table->decimal('dif_peso', 6, 2)->nullable(); // puede ser negativo
            $table->decimal('cmb_mm', 6, 2)->nullable();
            $table->decimal('amb_mm2', 10, 2)->nullable();
            $table->decimal('agb_mm2', 10, 2)->nullable();

            // Z-scores + diagnósticos manuales
            $table->decimal('z_imc', 4, 2)->nullable();
            $table->string('dx_z_imc', 100)->nullable();

            $table->decimal('z_talla', 4, 2)->nullable();
            $table->string('dx_z_talla', 100)->nullable();

            $table->decimal('z_pb', 4, 2)->nullable();
            $table->string('dx_z_pb', 100)->nullable();

            $table->decimal('z_pct', 4, 2)->nullable();
            $table->string('dx_z_pct', 100)->nullable();

            $table->decimal('z_cmb', 4, 2)->nullable();
            $table->string('dx_z_cmb', 100)->nullable();

            $table->decimal('z_amb', 4, 2)->nullable();
            $table->string('dx_z_amb', 100)->nullable();

            $table->decimal('z_agb', 4, 2)->nullable();
            $table->string('dx_z_agb', 100)->nullable();

            $table->foreignId('registrado_por')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();

            // Índices útiles
            $table->index(['medida_id']);
            $table->index(['oms_ref_id']);
            $table->index(['frisancho_ref_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluaciones');
    }
};
