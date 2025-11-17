<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

// Ruta principal - welcome
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Rutas de autenticación
Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// Si quieres mantener una ruta dashboard también
Route::get('/dashboard', function () {
    return view('welcome'); // O crea una vista específica para dashboard
})->middleware('auth')->name('dashboard');


use App\Http\Controllers\UsuarioController;

Route::middleware(['auth'])->group(function () {
    // Rutas para gestión de usuarios - solo admin y superadmin
    Route::middleware(['role:Admin|SuperAdmin'])->group(function () {
        Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
        Route::get('/usuarios/create', [UsuarioController::class, 'create'])->name('usuarios.create');
        Route::post('/usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');
        Route::get('/usuarios/{usuario}', [UsuarioController::class, 'show'])->name('usuarios.show');
        Route::get('/usuarios/{usuario}/edit', [UsuarioController::class, 'edit'])->name('usuarios.edit');
        Route::put('/usuarios/{usuario}', [UsuarioController::class, 'update'])->name('usuarios.update');
        Route::delete('/usuarios/{usuario}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');
    });
});



use App\Http\Controllers\PacienteController;

Route::middleware(['auth'])->group(function () {
    Route::middleware(['role:Nutricionista|SuperAdmin'])->group(function () {
        // Rutas para pacientes (incluyen gestión de tutores)
        Route::resource('pacientes', PacienteController::class);

        // Ruta adicional para buscar tutores (para select2 o similar)
        Route::get('/pacientes/tutores/buscar', [PacienteController::class, 'getTutores'])
            ->name('pacientes.tutores.buscar');

        // Ruta para cambiar estado del paciente
        Route::patch('/pacientes/{paciente}/estado', [PacienteController::class, 'destroy'])
            ->name('pacientes.estado');
    });
});







use App\Http\Controllers\MedidaController;

Route::middleware(['auth'])->group(function () {
    Route::middleware(['role:Nutricionista|SuperAdmin'])->group(function () {
        Route::controller(MedidaController::class)->group(function () {
            Route::get('/medidas', 'index')->name('medidas.index');
            Route::get('/medidas/create/{paciente}', 'create')->name('medidas.create');
            Route::post('/medidas/calcular-preview', 'calcularPreview')->name('medidas.calcular-preview');
            Route::post('/medidas', 'store')->name('medidas.store');
            Route::get('/medidas/{medida}', 'show')->name('medidas.show');
            Route::get('/medidas/{medida}/edit', 'edit')->name('medidas.edit');
            Route::put('/medidas/{medida}', 'update')->name('medidas.update'); // ← AGREGAR ESTA LÍNEA
            Route::patch('/medidas/{medida}/toggle-estado', 'toggleEstado')->name('medidas.toggle-estado');
            Route::get('/medidas/{medida}/calculos', 'calculos')->name('medidas.calculos');
        });
    });
});


use App\Http\Controllers\RequerimientoNutricionalController;

Route::middleware(['auth'])->group(function () {
    Route::middleware(['role:Nutricionista|SuperAdmin'])->group(function () {
        Route::resource('requerimiento_nutricional', RequerimientoNutricionalController::class)
            ->parameters([
                'requerimiento_nutricional' => 'requerimientoNutricional'
            ])
            ->names([
                'index' => 'requerimiento_nutricional.index',
                'create' => 'requerimiento_nutricional.create',
                'store' => 'requerimiento_nutricional.store',
                'show' => 'requerimiento_nutricional.show',
                'edit' => 'requerimiento_nutricional.edit',
                'update' => 'requerimiento_nutricional.update',
                'destroy' => 'requerimiento_nutricional.destroy',
            ]);

        // Ruta adicional para cambiar estado
        Route::patch('requerimiento_nutricional/{requerimientoNutricional}/cambiar-estado', 
            [RequerimientoNutricionalController::class, 'cambiarEstado'])
            ->name('requerimiento_nutricional.cambiar-estado');

        // Ruta para obtener última medida (AJAX)
        Route::get('requerimiento_nutricional/ultima-medida/{pacienteId}', 
            [RequerimientoNutricionalController::class, 'getUltimaMedida'])
            ->name('requerimiento_nutricional.ultima-medida');
            Route::get('requerimiento_nutricional/historial/{paciente}', 
    [RequerimientoNutricionalController::class, 'historial'])
    ->name('requerimiento_nutricional.historial');

    Route::get('requerimiento_nutricional/activo/{pacienteId}', 
    [RequerimientoNutricionalController::class, 'getRequerimientoActivo'])
    ->name('requerimiento_nutricional.activo');
    });
});


use App\Http\Controllers\MoleculaCaloricaController;

Route::middleware(['auth'])->group(function () {
    Route::middleware(['role:Nutricionista|SuperAdmin'])->group(function () {
        Route::get('moleculaCalorica', [MoleculaCaloricaController::class, 'index'])->name('moleculaCalorica.index');
        Route::get('moleculaCalorica/create', [MoleculaCaloricaController::class, 'create'])->name('moleculaCalorica.create');
        Route::get('moleculaCalorica/create/{paciente}', [MoleculaCaloricaController::class, 'create'])->name('moleculaCalorica.create.for.paciente');
        Route::post('moleculaCalorica', [MoleculaCaloricaController::class, 'store'])->name('moleculaCalorica.store');
        Route::get('moleculaCalorica/{moleculaCalorica}', [MoleculaCaloricaController::class, 'show'])->name('moleculaCalorica.show');
        Route::get('moleculaCalorica/{moleculaCalorica}/edit', [MoleculaCaloricaController::class, 'edit'])->name('moleculaCalorica.edit');
        Route::put('moleculaCalorica/{moleculaCalorica}', [MoleculaCaloricaController::class, 'update'])->name('moleculaCalorica.update');
        Route::delete('moleculaCalorica/{moleculaCalorica}', [MoleculaCaloricaController::class, 'destroy'])->name('moleculaCalorica.destroy');
    });
});
