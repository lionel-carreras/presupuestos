<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PresupuestoDetalle extends Model
{
    protected $table='PresupuestosDetalle';

    public $timestamps = false;

    protected $fillable = [

       'PresupuestoID', 'Renglon', 'Cantidad', 'Item', 'Importe'

   ];
}
