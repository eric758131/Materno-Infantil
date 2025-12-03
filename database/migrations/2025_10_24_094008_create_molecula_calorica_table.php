<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('molecula_calorica', function (Blueprint $table) {
            $table->id();

            // Relaciones
            $table->foreignId('paciente_id')
                ->constrained('pacientes')
                ->cascadeOnDelete();

            $table->foreignId('medida_id')
                ->nullable()
                ->constrained('medidas')
                ->nullOnDelete(); // Último registro de medidas (peso/talla)

            $table->foreignId('requerimiento_id')
                ->nullable()
                ->constrained('requerimientos_nutricionales')
                ->nullOnDelete(); // Para obtener GET_KCAL

            // Snapshot de datos base
            $table->decimal('peso_kg', 6, 2);   // Traído de la última medida
            $table->decimal('talla_cm', 5, 2);  // Traído de la última medida
            $table->decimal('kilocalorias_totales', 8, 2); // GET_KCAL

            // Datos calculados de la molécula calórica
            $table->decimal('proteinas_g_kg', 5, 2)->nullable();
            $table->decimal('grasas_g_kg', 5, 2)->nullable();
            $table->decimal('carbohidratos_g_kg', 5, 2)->nullable();

            $table->decimal('kilocalorias_proteinas', 8, 2)->nullable();
            $table->decimal('kilocalorias_grasas', 8, 2)->nullable();
            $table->decimal('kilocalorias_carbohidratos', 8, 2)->nullable();

            $table->decimal('porcentaje_proteinas', 5, 2)->nullable();
            $table->decimal('porcentaje_grasas', 5, 2)->nullable();
            $table->decimal('porcentaje_carbohidratos', 5, 2)->nullable();

            // ✅ Estado del registro   
            $table->foreignId('registrado_por')->constrained('users');
            $table->enum('estado', ['activo', 'inactivo'])->default('activo');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('molecula_calorica');
    }
};
