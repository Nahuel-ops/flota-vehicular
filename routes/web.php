<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MantenimientoController;
use App\Http\Controllers\VehiculoController; // ← IMPORTACIÓN DEL NUEVO CONTROLADOR DE VEHÍCULOS
//agregar ChoferController
use App\Http\Controllers\ChoferController;

//Agregar RepuestosController
use App\Http\Controllers\RepuestoController;


use Illuminate\Support\Facades\Route;

// Rutas de invitados (Sencillo: si ya iniciaron sesión, no pueden ver esto)
Route::middleware('guest')->group(function () {
    Route::get('/registro', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/registro', [AuthController::class, 'register']);
    
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Rutas protegidas (Solo usuarios logueados)
Route::middleware('auth')->group(function () {
    
    // ARQUITECTURA LIMPIA: La ruta invoca al controlador correspondiente
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // RUTAS DEL MÓDULO DE MANTENIMIENTO (Opción B Integrada)
    Route::get('/mantenimientos', [MantenimientoController::class, 'index'])->name('mantenimientos.index');
    Route::get('/mantenimientos/crear', [MantenimientoController::class, 'create'])->name('mantenimientos.create');
    Route::post('/mantenimientos', [MantenimientoController::class, 'store'])->name('mantenimientos.store');

    // RUTAS COMPLETAS DEL CRUD DE VEHÍCULOS (Opción C Exigida)
    Route::get('/vehiculos', [VehiculoController::class, 'index'])->name('vehiculos.index');
    Route::get('/vehiculos/crear', [VehiculoController::class, 'create'])->name('vehiculos.create');
    Route::post('/vehiculos', [VehiculoController::class, 'store'])->name('vehiculos.store');
    Route::get('/vehiculos/{id}/editar', [VehiculoController::class, 'edit'])->name('vehiculos.edit');
    Route::put('/vehiculos/{id}', [VehiculoController::class, 'update'])->name('vehiculos.update');
    Route::delete('/vehiculos/{id}', [VehiculoController::class, 'destroy'])->name('vehiculos.destroy');

        // RUTAS COMPLETAS DEL CRUD DE CHOFERES (Módulo Personal)
    Route::get('/choferes', [ChoferController::class, 'index'])->name('choferes.index');
    Route::get('/choferes/crear', [ChoferController::class, 'create'])->name('choferes.create');
    Route::post('/choferes', [ChoferController::class, 'store'])->name('choferes.store');
    Route::get('/choferes/{id}/editar', [ChoferController::class, 'edit'])->name('choferes.edit');
    Route::put('/choferes/{id}', [ChoferController::class, 'update'])->name('choferes.update');
    Route::delete('/choferes/{id}', [ChoferController::class, 'destroy'])->name('choferes.destroy');

        // RUTAS COMPLETAS DEL CRUD DE REPUESTOS (Catálogo de Insumos)
    Route::get('/repuestos', [RepuestoController::class, 'index'])->name('repuestos.index');
    Route::get('/repuestos/crear', [RepuestoController::class, 'create'])->name('repuestos.create');
    Route::post('/repuestos', [RepuestoController::class, 'store'])->name('repuestos.store');
    Route::get('/repuestos/{id}/editar', [RepuestoController::class, 'edit'])->name('repuestos.edit');
    Route::put('/repuestos/{id}', [RepuestoController::class, 'update'])->name('repuestos.update');
    Route::delete('/repuestos/{id}', [RepuestoController::class, 'destroy'])->name('repuestos.destroy');

    // Cierre de Sesión Seguro
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Redirección por defecto
Route::get('/', function () {
    return redirect()->route('login');
});
