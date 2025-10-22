<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('oms_ref', function (Blueprint $table) {
        $table->id();
        $table->enum('genero', ['masculino', 'femenino']); // igual que pacientes
        $table->unsignedSmallInteger('edad_meses');

        $table->decimal('imc_menos_sd', 5, 2);
        $table->decimal('imc_mediana', 5, 2);
        $table->decimal('imc_mas_sd', 5, 2);

        $table->decimal('talla_menos_sd_cm', 5, 2);
        $table->decimal('talla_mediana_cm', 5, 2);
        $table->decimal('talla_mas_sd_cm', 5, 2);

        $table->timestamps();
        $table->unique(['genero', 'edad_meses']);
    });


    }

    public function down(): void
    {
        Schema::dropIfExists('oms_ref');
    }
};
