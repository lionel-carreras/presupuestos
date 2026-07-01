<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trayectos extends Model
{
    protected $table='Trayectos';// Definir los campos que se pueden asignar masivamente
    protected $fillable = [
        'TrayectoID', 'ListaTarifa',
    ];
}
