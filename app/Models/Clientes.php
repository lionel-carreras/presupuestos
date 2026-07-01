<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
 protected $table='Clientes';

 public $timestamps = false;

 protected $primaryKey = 'ClienteID';


 protected $fillable = [
    'ClienteNombre',
    'DomicilioFiscal',
    'DomicilioEntrega1',
    'CodigoPostalFiscal',
    'CodigoPostal1',
    'ZonaFiscal',
    'ZonaID',
    'ZonaID1',
    'TipoIva',
    'CUIT',
    'CuentaCorriente',
    'Telefono',
    'Email',
    'LimiteCredito',
    'Estado',
    'Seguro',
    'Descuento',
    'SeguroPropio',
    'SucursalCobranza',
    'SucursalCobranza1',
    'SucursalEntregaFiscal',
    'SucursalEntrega1',
    'CondicionesCobranza',
    'FechaUltimaActualizacion',
    'FechaAlta',
    'SucursalID',
    'Ocasional',
    'CobraAdicionalAdministrativo',
    'TarifaPlana',
    'SiemprePaga',
    'NuncaPaga',
    'EmpleadoAlta',
    'PagaSobreContra',
    'CondicionesEspeciales',
    'DNI',
    'DomEntregaNroReg',
    'Bloqueado',
    'DiasSaldoPendiente',
    'UsuarioIdAlta'
];


}
