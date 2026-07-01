<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DomicilioEntrega extends Model
{
    protected $table = 'ClientesDomicilioEntrega';

    public $timestamps = false;

    protected $fillable = [
        'NroRegistro',
        'ClienteId',
        'Domicilio',
        'CodigoPostal',
        'FechaLog',
        'HoraLog',
        'UsuarioLog',
        'Estado',
        'Telefono',
        'Observaciones',
        'SucursalId',
        'Moda',
        'Piso',
        'Dpto',
        'NroCalle',
        'CalleId',
        'ZonaId',
        'LocalidadId'
     ];
    }

