<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('frisancho_ref', function (Blueprint $table) {
        $table->id();
        $table->enum('genero', ['masculino', 'femenino']); // igual que pacientes
        $table->unsignedSmallInteger('edad_anios');

        $table->decimal('pb_menos_sd', 6, 2);
        $table->decimal('pb_dato', 6, 2);
        $table->decimal('pb_mas_sd', 6, 2);

        $table->decimal('pct_menos_sd', 6, 2);
        $table->decimal('pct_dato', 6, 2);
        $table->decimal('pct_mas_sd', 6, 2);

        $table->decimal('cmb_menos_sd', 6, 2);
        $table->decimal('cmb_dato', 6, 2);
        $table->decimal('cmb_mas_sd', 6, 2);

        $table->decimal('amb_menos_sd', 10, 2);
        $table->decimal('amb_dato', 10, 2);
        $table->decimal('amb_mas_sd', 10, 2);

        $table->decimal('agb_menos_sd', 10, 2);
        $table->decimal('agb_dato', 10, 2);
        $table->decimal('agb_mas_sd', 10, 2);

        $table->timestamps();
        $table->unique(['genero', 'edad_anios']);
    });



    }

    public function down(): void
    {
        Schema::dropIfExists('frisancho_ref');
    }
};
