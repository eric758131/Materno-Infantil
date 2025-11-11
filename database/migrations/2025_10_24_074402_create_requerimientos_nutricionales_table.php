<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('requerimientos_nutricionales', function (Blueprint $table) {
            $table->id();

            // Relaciones
            $table->foreignId('paciente_id')->constrained('pacientes')->cascadeOnDelete();
            $table->foreignId('medida_id')->nullable()->constrained('medidas')->nullOnDelete();

            // Snapshot de la última evaluación (peso/talla)
            $table->decimal('peso_kg_at', 6, 2);
            $table->decimal('talla_cm_at', 5, 2);

            // Datos del requerimiento
            $table->decimal('geb_kcal', 8, 2);
            $table->decimal('factor_actividad', 4, 2);
            $table->decimal('factor_lesion', 4, 2);
            $table->decimal('get_kcal', 8, 2);
            $table->decimal('kcal_por_kg', 6, 2);

            // Estado y auditoría
            $table->enum('estado', ['activo','inactivo'])->default('activo');
            $table->foreignId('registrado_por')->constrained('users'); // usuario que lo registró
            $table->timestamp('calculado_en')->useCurrent();

            $table->timestamps();

            $table->index(['paciente_id', 'calculado_en']);
        });

        // (Opcional para PostgreSQL) Check de estado
        if (DB::getDriverName() === 'pgsql') {
            DB::statement("ALTER TABLE requerimientos_nutricionales
                ADD CONSTRAINT requerimientos_estado_chk
                CHECK (estado IN ('activo','inactivo'));");
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('requerimientos_nutricionales');
    }
};
