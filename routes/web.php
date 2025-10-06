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