<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('medidas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paciente_id')->constrained('pacientes')->cascadeOnDelete();
            $table->date('fecha');
            $table->unsignedSmallInteger('edad_meses'); // snapshot para reproducibilidad
            $table->decimal('peso_kg', 6, 2);
            $table->decimal('talla_cm', 5, 2);
            $table->decimal('pb_mm', 6, 2)->nullable();
            $table->decimal('pct_mm', 6, 2)->nullable();
            $table->string('estado', 10)->default('Activo'); // Activo | Inactivo
            $table->timestamps();
        });

        // Check para valores válidos de estado en PostgreSQL
        DB::statement("ALTER TABLE medidas
            ADD CONSTRAINT medidas_estado_chk CHECK (estado IN ('Activo','Inactivo'));");
    }

    public function down(): void
    {
        Schema::dropIfExists('medidas');
    }
};
