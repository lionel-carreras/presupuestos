<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clientes;
use App\Models\Calles;
use App\Models\DomicilioEntrega;
use Illuminate\Support\Facades\DB;

class ClientesController extends Controller
{
    public function buscar(Request $request)
    {
        $query = $request->input('query');

        // Validar que la longitud mínima sea 3 caracteres
        if (strlen($query) < 3) {
            return response()->json([]);
        }

        // Buscar clientes por CUIT o parte del nombre
        $resultados = Clientes::where('CUIT', 'like', "%$query%")
             ->orWhere('DNI', 'like', "%$query%")
            ->orWhere('ClienteNombre', 'like', "%$query%")
            ->take(10) // Limitar resultados
            ->get(['ClienteID', 'DNI', 'ClienteNombre', 'CUIT']);

        return response()->json($resultados);
    }

    public function insertarClienteNuevo(Request $request)
    {
        return DB::transaction(function () use ($request) {
            // Validar datos del formulario
            $validated = $request->validate([
                'nuevoClienteNombre'          => 'required|string|max:255',
                'nuevoClienteLocalidadHidden' => 'required|string',  // Contiene el código postal
                'nuevoClienteTipoCalle'       => 'required|string|max:50',
                'nuevoClienteCalle'           => 'required|string|max:255',
                'nuevoClienteNumero'          => 'required|numeric',
                'nuevoClientePiso'            => 'nullable|string|max:50',
                'nuevoClienteDpto'            => 'nullable|string|max:50',
                'nuevoClienteRef'             => 'nullable|string|max:255',
                'nuevoClienteTipoIva'         => 'required|string',
                'nuevoClienteCuitDni'         => 'required|string',
                'nuevoClienteTelefono'        => 'required|string',
                'nuevoClienteMail'            => 'required|email',
            ]);

            // Convertir Tipo IVA a abreviatura
            $tipoIvaInput = $validated['nuevoClienteTipoIva'];
            switch (strtolower($tipoIvaInput)) {
                case 'consfinal':
                case 'consumidor final':
                    $tipoIva = 'CF';
                    break;
                case 'exento':
                    $tipoIva = 'EX';
                    break;
                case 'ri':
                case 'responsable inscripto':
                    $tipoIva = 'RI';
                    break;
                default:
                    $tipoIva = $tipoIvaInput;
            }

            \Log::info('Datos validados:', $validated);

            // Se asume que "nuevoClienteLocalidadHidden" contiene el código postal.
            $codigoPostal = $validated['nuevoClienteLocalidadHidden'];

            // Consultar en LocalidadesNew para obtener el LocalidadID real
            $localidadRecord = DB::table('LocalidadesNew')
                ->where('CodigoPostal', $codigoPostal)
                ->first();
            if (!$localidadRecord) {
                return response()->json([
                    'ok' => false,
                    'mensaje' => 'La localidad especificada no existe en el sistema.'
                ], 400);
            }
            $localidadID = $localidadRecord->LocalidadID;

            // Verificar si la calle ya existe en CallesNew
            $calleNombre = $validated['nuevoClienteCalle'];
            $calleTipo   = $validated['nuevoClienteTipoCalle'];
            $calle = Calles::whereRaw('LOWER(CalleNombre) = ?', [mb_strtolower($calleNombre)])
                ->where('CalleTipo', $calleTipo)
                ->where('CodigoPostalNew', $codigoPostal)
                ->where('LocalidadID', $localidadID)
                ->first();
            if (!$calle) {
                $calle = Calles::create([
                    'CalleNombre'     => $calleNombre,
                    'CalleTipo'       => $calleTipo,
                    'CodigoPostalNew' => $codigoPostal,
                    'LocalidadID'     => $localidadID,
                    'UsuarioId'       => 1634,
                    'FechaAlta'       => date('Y-m-d'),
                    'Controlada'      => 's',
                ]);
            }

            // Primero se crea el cliente sin el valor de DomEntregaNroReg
            $cliente = Clientes::create([
                'ClienteNombre'       => $validated['nuevoClienteNombre'],
                'DomicilioFiscal'     => $validated['nuevoClienteCalle'] . ' ' . $validated['nuevoClienteNumero'],
                'DomicilioEntrega1'     => $validated['nuevoClienteCalle'] . ' ' . $validated['nuevoClienteNumero'],
                'CodigoPostalFiscal'  => $codigoPostal,
                'CodigoPostal1'       => $codigoPostal,
                'ZonaFiscal'          => 1,
               // 'ZonaID'              => 1,
                'ZonaID1'              => 1,
                'TipoIva'             => $tipoIva,
                'CUIT'                => $validated['nuevoClienteCuitDni'],
                'Telefono'            => $validated['nuevoClienteTelefono'],
                'Email'               => $validated['nuevoClienteMail'],
                'LimiteCredito'       => 20000,
                'Estado'              => 'A',
                'Seguro'              => 10,
                'Descuento'              => 0.00,
                'SeguroPropio'              => 0.00,
                'SucursalCobranza'    => 101,
                'SucursalCobranza1'    => 101,
                'SucursalEntregaFiscal' => $request->input('sucursalEntregaFiscal'),
                'SucursalEntrega1' => $request->input('sucursalEntregaFiscal'),
                'CuentaCorriente'    => 0,
                'CondicionesCobranza' => 'CONTADO',
                'FechaUltimaActualizacion' => date('Y-m-d'),
                'FechaAlta' => date('Y-m-d'),
                'SucursalID'          => $request->input('sucursalEntregaFiscal'),
                'Ocasional'          => 0,
                'CobraAdicionalAdministrativo'          => 1,
                'TarifaPlana'          => 0.00,
                'SiemprePaga'          => 0,
                'NuncaPaga'          => 0,
                'EmpleadoAlta'        => 1634,
                'PagaSobreContra'=> 1,
                'CondicionesEspeciales' => 0,
                'DNI'                 => $validated['nuevoClienteCuitDni'],
                'DomEntregaNroReg'    => 0,
                'Bloqueado'           => 'N',
                'DiasSaldoPendiente'   => 0,
                'UsuarioIdAlta'       => 1634,
                'PermiteRemitosenCero'       => 0,
                'ContadoPendiente'       => 0,
                'Canje'       => 0,
                'Recargo'       => 0.00,
                'ValorCRR'       => 0.00,

            ]);

            // Calcular el siguiente NroRegistro para ClientesDomicilioEntrega
            $nextNroRegistro = DomicilioEntrega::max('NroRegistro');
            $nextNroRegistro = is_null($nextNroRegistro) ? 1 : $nextNroRegistro + 1;

            // Construir los datos del domicilio, incluyendo el ClienteId
            $domicilioData = [
                'NroRegistro'  => $nextNroRegistro,
                'ClienteId'    => $cliente->ClienteID,  // Usa la propiedad correcta según la clave primaria
                'Domicilio'    => $validated['nuevoClienteCalle'], // Solo el nombre de la calle
                'CodigoPostal' => $codigoPostal,
                'FechaLog'     => date('Y-m-d'),
                'HoraLog'      => date('H:i:s'),
                'UsuarioLog'   => 1634,
                'Estado'       => 'A',
                'Telefono'     => $validated['nuevoClienteTelefono'],
                'Observaciones'=> $validated['nuevoClienteRef'] ?? null,
                'SucursalId'   => $request->input('sucursalEntregaFiscal'),
                'Moda'         => null,
                'Piso'         => $validated['nuevoClientePiso'] ?? null,
                'Dpto'         => $validated['nuevoClienteDpto'] ?? null,
                'NroCalle'     => $validated['nuevoClienteNumero'],
                'CalleId'      => $calle->CalleID,  // Asumiendo que el modelo Calles tiene primaryKey "CalleID"
                'ZonaId'       => 1,
                'LocalidadId'  => $localidadID,
            ];

            // Insertar el domicilio. Esto debe pasar un valor para NroRegistro.
            $domicilioEntrega = DomicilioEntrega::create($domicilioData);
            $nroRegistroGenerado = $domicilioEntrega->NroRegistro;

            // Actualizar el cliente para asignar DomEntregaNroReg con el NroRegistro obtenido
            $cliente->update(['DomEntregaNroReg' => $nroRegistroGenerado]);

            return response()->json([
                'ok'      => true,
                'mensaje' => 'Cliente cargado en la base de datos',
                'cliente' => array_merge($cliente->toArray(), ['id' => $cliente->ClienteID])
            ]);
        });
    }
    }


