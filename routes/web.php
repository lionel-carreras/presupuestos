<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LocalidadesController;
use App\Http\Controllers\PresupuestoController;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\CallesController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/diagnostico-db', function (Request $request) {
    $expectedToken = env('DIAGNOSTICS_TOKEN');

    if (!$expectedToken) {
        abort(404);
    }

    if (!hash_equals($expectedToken, (string) $request->query('token'))) {
        abort(403);
    }

    $connectionName = config('database.default');
    $connection = config("database.connections.{$connectionName}", []);
    $result = [
        'app_env' => config('app.env'),
        'connection' => $connectionName,
        'driver' => $connection['driver'] ?? null,
        'host' => $connection['host'] ?? null,
        'port' => $connection['port'] ?? null,
        'database' => $connection['database'] ?? null,
        'username_present' => !empty($connection['username']),
        'password_present' => !empty($connection['password']),
        'php_extensions' => [
            'pdo' => extension_loaded('pdo'),
            'sqlsrv' => extension_loaded('sqlsrv'),
            'pdo_sqlsrv' => extension_loaded('pdo_sqlsrv'),
        ],
        'pdo_drivers' => class_exists(PDO::class) ? PDO::getAvailableDrivers() : [],
    ];

    try {
        $result['query'] = DB::connection()->select('SELECT 1 AS ok');
        $result['ok'] = true;
    } catch (Throwable $exception) {
        $result['ok'] = false;
        $result['error_class'] = get_class($exception);
        $result['error_message'] = $exception->getMessage();
    }

    return response()->json($result);
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
