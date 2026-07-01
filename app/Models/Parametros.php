<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parametros extends Model
{
    protected $table='ParametrosSeguroVD';// Definir los campos que se pueden asignar masivamente
    protected $fillable = [
        'ValorId', 'DescripcionValor', 'ValorIni' , 'ValorFin' , 'Importe'
    ];
}
