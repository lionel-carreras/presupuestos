<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SucursalesTrayecto extends Model
{
    protected $table='SucursalesTrayectos';// Definir los campos que se pueden asignar masivamente
    protected $fillable = [
        'SucursalOrigen', 'SucursalDestino', 'TrayectoID',
    ];
}

