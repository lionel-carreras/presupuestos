<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocalidadesNew extends Model
{
    use HasFactory;

    protected $table = 'LocalidadesNew'; // Nombre exacto de la tabla en la base de datos

    protected $primaryKey = 'LocalidadID'; // Clave primaria si no es "id"

    public $timestamps = false;

    protected $fillable = [
        'LocalidadNombre', 'CodigoPostal', 'SucursalId',
    ];

    /**
     * Scope para filtrar localidades con SucursalId distinto de 0.
     */
    public function scopeConSucursal($query)
    {
        return $query->where('SucursalId', '<>', 0);
    }
}
