<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoleculaCaloricaTable extends Migration
{
    public function up()
    {
        Schema::create('molecula_calorica', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paciente_id')->constrained()->onDelete('cascade'); // FK a pacientes.id
            $table->decimal('peso_kg', 5, 2); // Peso en kg
            $table->decimal('proteínas_g_kg', 5, 2)->nullable(); // Proteínas en g/Kg
            $table->decimal('grasa_g_kg', 5, 2)->nullable(); // Grasas en g/Kg
            $table->decimal('carbohidratos_g_kg', 5, 2)->nullable(); // Carbohidratos en g/Kg
            $table->decimal('kilocalorías_totales', 8, 2)->nullable(); // Total de kcal
            $table->decimal('kilocalorías_proteínas', 8, 2)->nullable(); // Kilocalorías de proteínas
            $table->decimal('kilocalorías_grasas', 8, 2)->nullable(); // Kilocalorías de grasas
            $table->decimal('kilocalorías_carbohidratos', 8, 2)->nullable(); // Kilocalorías de carbohidratos
            $table->enum('estado', ['activo', 'inactivo'])->default('activo');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('molecula_calorica');
    }
}
