<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calles extends Model
{
    protected $table='CallesNew';

    public $timestamps = false;
    protected $primaryKey = 'CalleID';


    protected $fillable = [

       'CalleNombre', 'CalleTipo','CodigoPostalNew','LocalidadID','UsuarioId','FechaAlta','Controlada'
   ];
}
