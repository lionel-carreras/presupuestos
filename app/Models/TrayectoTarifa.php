<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrayectoTarifa extends Model
{
    protected $table='TrayectosTarifas';// Definir los campos que se pueden asignar masivamente
    protected $fillable = [
        'TrayectoID', 'KgDesde', 'KgHasta', 'Tarifa',
    ];
}
