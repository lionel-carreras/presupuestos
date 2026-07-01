<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presupuesto extends Model
{
    protected $table = 'Presupuestos';

    // Indica la columna que es PK:
    protected $primaryKey = 'PresupuestoID';

    // Si la columna PresupuestoID es auto-increment (IDENTITY en SQL Server):
    public $incrementing = true;

    // Si no usas created_at / updated_at:
    public $timestamps = false;

    protected $fillable = [
       'ClientePrincipalID', 'EnviaRecibe', 'FechaDesde', 'FechaHasta',
       'Descripcion', 'Total', 'Activo', 'EnvioID', 'EmpleadoId', 'UsuarioId',
       'SucursalIDOrigen', 'SucursalIDDestino', 'TarifaID'
    ];
}

