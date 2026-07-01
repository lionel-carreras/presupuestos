<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LocalidadesController;
use App\Http\Controllers\PresupuestoController;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\CallesController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/buscar-localidades', [LocalidadesController::class, 'buscar']);

Route::post('/calcular', [PresupuestoController::class, 'calcularPresupuesto'])->name('calcular');

Route::get('/buscar-clientes', [ClientesController::class, 'buscar']);

Route::post('/calcular-presupuesto', [PresupuestoController::class, 'calcularPresupuesto'])
    ->name('calcular.presupuesto');

Route::post('/enviar-correo-presupuesto', [PresupuestoController::class, 'enviarCorreoPresupuesto'])
    ->name('enviar.correo.presupuesto');

Route::get('/buscar-calles', [CallesController::class, 'buscarCalles']);
Route::post('/cliente/nuevo/insert', [\App\Http\Controllers\ClientesController::class, 'insertarClienteNuevo'])->name('cliente.nuevo.insert');
