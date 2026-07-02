<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

use App\Models\LocalidadesNew;
use App\Models\SucursalesTrayecto;
use App\Models\Trayectos;
use App\Models\TrayectoTarifa;
use App\Models\Parametros;
use App\Models\Clientes;
use App\Models\Presupuesto;
use App\Models\PresupuestoDetalle;
use App\Mail\PresupuestoMail;
use App\Mail\RetiroSolicitadoMail;

class PresupuestoController extends Controller
{
    /**
     * Primer endpoint: calcula y retorna JSON, sin enviar el correo.
     */
    // Aquí tu lista de Sucursales => correos, usando arrays
    protected $sucursalEmails = [
        8  => ['lionelcarreras.it@gmail.com'],//['parana@brio.com.ar'],
        41 => ['lionelcarreras.it@gmail.com'],//['gualeguaychu@brio.com.ar'],
        2  => ['lionelcarreras.it@gmail.com'],//['cordoba@brio.com.ar'],
        11 => ['lionelcarreras.it@gmail.com'],//['villamaria@brio.com.ar'],
        16 => ['lionelcarreras.it@gmail.com'],//['sanfrancisco@brio.com.ar'],


        12 => ['lionelcarreras.it@gmail.com'],//['mendoza@brio.com.ar'],

        30 => ['lionelcarreras.it@gmail.com'],//['sanrafael@brio.com.ar'],
        18 => ['lionelcarreras.it@gmail.com'],//['sanjuan@brio.com.ar'],


        34 => ['lionelcarreras.it@gmail.com'],//['tucuman@brio.com.ar','tucuman@brio.com.ar'],


        1  => ['lionelcarreras.it@gmail.com'],//['retiros@brio.com.ar'],
        10  => ['lionelcarreras.it@gmail.com'],


        24 => ['lionelcarreras.it@gmail.com'],//['mardelplata@brio.com.ar'],

        4  => ['lionelcarreras.it@gmail.com'],//['santafe@brio.com.ar'],
        7  => ['lionelcarreras.it@gmail.com'],//['rafaela@brio.com.ar'],
        37 => ['lionelcarreras.it@gmail.com'],//['sanlorenzo@brio.com.ar'],
        23 => ['lionelcarreras.it@gmail.com'],//['junin@brio.com.ar'],
        22 => ['lionelcarreras.it@gmail.com'],//['pergamino@brio.com.ar'],
        3  => ['lionelcarreras.it@gmail.com'],//['pompeya@brio.com.ar'],
    ];


    public function calcularPresupuesto(Request $request)
    {
        // 1. Datos del cliente
        $clienteCuit   = $request->input('cliente_cuit');
        $clienteNombre = $request->input('cliente_nombre');
        $clienteMail   = $request->input('cliente_mail');
        $cliente_id    = $request->input('cliente_id');

        // 2. Verificar si el cliente posee tarifa acordada
        $cliente = Clientes::where('CUIT', $clienteCuit)->first();
        if ($cliente && $cliente->CondicionesEspeciales == 1) {
            return response()->json([
                'error'   => true,
                'mensaje' => 'La firma ' . $clienteNombre . ' posee tarifa acordada, por favor comuníquese con su asesor comercial.'
            ]);
        }

        // 3. Obtener CP de origen y destino
        $origenCodigoPostal  = $request->input('cp_origen');
        $destinoCodigoPostal = $request->input('cp_destino');

        $origen  = LocalidadesNew::where('CodigoPostal', $origenCodigoPostal)->first();
        $destino = LocalidadesNew::where('CodigoPostal', $destinoCodigoPostal)->first();

        $origenSucursalID  = $origen->SucursalId ?? null;
        $destinoSucursalID = $destino->SucursalId ?? null;

        // 4. Buscar el trayecto
        $trayectoID = null;
        if ($origenSucursalID && $destinoSucursalID) {
            $trayecto = SucursalesTrayecto::where('SucursalOrigen', $origenSucursalID)
                ->where('SucursalDestino', $destinoSucursalID)
                ->first();
            $trayectoID = $trayecto->TrayectoID ?? null;
        }

        // 5. Obtener Descripción y ListaTarifa
        $descripcion = null;
        $listaTarifa = null;
        if ($trayectoID) {
            $trayectoDetalles = Trayectos::where('TrayectoID', $trayectoID)->first();
            if ($trayectoDetalles) {
                $descripcion = $trayectoDetalles->Descripcion;
                $listaTarifa = $trayectoDetalles->TrayectoID;
            }
        }

        // 6. Datos de entrada
        $alto     = $request->input('alto');
        $ancho    = $request->input('ancho');
        $largo    = $request->input('largo');
        $cantidad = $request->input('cantidad');
        $kilos    = $request->input('kilos');
        $valor    = $request->input('valor');

        // 7. Peso volumétrico total
        $pesoVolumetricoUnitario = ($alto / 100) * ($ancho / 100) * ($largo / 100) * 750;
        $pesoVolumetricoTotal = round($pesoVolumetricoUnitario * $cantidad);

        // 8. Comparar con peso real
        $pesoFinal = max($pesoVolumetricoTotal, $kilos);

        // 9. Calcular tarifa y flete
        $tarifa = null;
        $flete  = 0;
        if ($listaTarifa) {
            $tarifaDetalles = TrayectoTarifa::where('TrayectoID', $listaTarifa)
                ->where('KgDesde', '<=', $pesoFinal)
                ->where('KgHasta', '>=', $pesoFinal)
                ->first();

            if ($tarifaDetalles) {
                $tarifaBase = $tarifaDetalles->Tarifa;
                // Multiplicar por peso si >= 1000 kg
                $tarifa = ($pesoFinal >= 1000)
                    ? $tarifaBase * $pesoFinal
                    : $tarifaBase;
            }

            $parametro = Parametros::where('ValorIni', '<=', $valor)
                ->where('ValorFin', '>=', $valor)
                ->first();

            if ($parametro) {
                if ($parametro->Importe > 0) {
                    $flete = $parametro->Importe;
                } elseif ($parametro->Porcentaje > 0) {
                    $flete = $valor * ($parametro->Porcentaje / 1000);
                }
            }
        }

        // 10. IVA y total
        $iva   = round(($flete + $tarifa) * 0.21, 2);
        $total = round($flete + $tarifa + $iva, 2);
        $tarifasola = round($flete - $tarifa - $iva, 2);

        // 11. Retornar JSON
        return response()->json([
            'error'           => false,
            'descripcion'     => $descripcion ?? 'No disponible',
            'tarifa'          => $tarifa,
            'pesoFinal'       => $pesoFinal,
            'flete'           => $flete,
            'iva'             => $iva,
            'total'           => $total,
            'clienteCuit'     => $clienteCuit,
            'cliente_id'      => $cliente_id,
            'clienteNombre'   => $clienteNombre,
            'clienteMail'     => $clienteMail,
            'origenLocalidad' => $origen->LocalidadNombre ?? 'No disponible',
            'destinoLocalidad'=> $destino->LocalidadNombre ?? 'No disponible',
            'sucursal_id_origen'  => $origenSucursalID,
            'sucursal_id_destino' => $destinoSucursalID,
            'tarifa_id'           => $listaTarifa,
            'cantidad'            => $cantidad // lo enviamos también
        ]);
    }

    /**
     * Segundo endpoint: recibe datos, envía el correo y hace el insert en la base.
     */
    public function enviarCorreoPresupuesto(Request $request)
    {
        // 1) Recibir el JSON con todos los datos
        $data = $request->all();

        // 2) Insertar en la base (Presupuesto y Detalle)
        $fechaDesde = Carbon::now();
        $fechaHasta = Carbon::now()->addWeekdays(3);

    $presupuesto = new Presupuesto();
    $presupuesto->ClientePrincipalID = $data['cliente_id'] ?? null;
    $presupuesto->ClienteSecundarioID = '5669880';
    $presupuesto->EnviaRecibe        = 'E';
    $presupuesto->FechaDesde         = $fechaDesde;
    $presupuesto->FechaHasta         = $fechaHasta;

        // Usaremos "descripcion_envio" (campo renombrado en el formulario) para la descripción del envío.
        // Si hay retiro, se usará el valor del input oculto "mercaderia_descripcion_hidden" (completado en el modal);
        // en caso contrario, se toma directamente el valor del input "descripcion_envio".
        if ($request->has('retirar_domicilio') && $request->input('retirar_domicilio')) {
            $descripcion = $request->input('mercaderia_descripcion_hidden') ?? 'Presupuesto Web';
        } else {
            $descripcion = $request->input('descripcion') ?? 'Presupuesto Web';
        }
        $presupuesto->Descripcion = $descripcion;


    $presupuesto->Total      = $data['tarifa'] ?? 0;
    $presupuesto->Activo     = 'S';
    $presupuesto->EnvioID    = null;
    $presupuesto->EmpleadoId = '11253';
    $presupuesto->UsuarioId  = '11253';

    $presupuesto->SucursalIDOrigen  = $data['sucursal_id_origen']  ?? null;
    $presupuesto->SucursalIDDestino = $data['sucursal_id_destino'] ?? null;
    $presupuesto->TarifaID          = $data['tarifa_id']           ?? null;

    $presupuesto->save();

    // Calcular tarifas, cantidad e importe
    $tarifasola = $data['tarifa'] ?? 0;
    $cantidad   = $data['cantidad'] ?? 1;
    $importe    = ($cantidad > 0) ? round($tarifasola / $cantidad, 2) : 0;

    // Insertar Detalle
    $detalle = new PresupuestoDetalle();
    $detalle->PresupuestoID = $presupuesto->PresupuestoID;
    $detalle->Renglon       = 1;
    $detalle->Cantidad      = $cantidad;
    $detalle->Item          = 'BULTOS';
    $detalle->Importe       = $importe;
    $detalle->save();

    // 3) Añadir valores definitivos a $data
    $data['fechaDesde']    = $fechaDesde->format('d/m/Y');
    $data['presupuestoID'] = $presupuesto->PresupuestoID;
    $data['tarifasola']    = $tarifasola;

    // Si hay retiro, guardar datos adicionales
    if ($request->has('retirar_domicilio') && $request->input('retirar_domicilio')) {
        $retiroData = [
            'pago_en'                    => $request->input('pago_en_hidden'),
            'remitente_nombre'           => $request->input('remitente_nombre_hidden'),
            'remitente_telefono'         => $request->input('remitente_telefono_hidden'),
            'remitente_mail'             => $request->input('remitente_mail_hidden'),
            'remitente_doc'              => $request->input('remitente_doc_hidden'),
            'retiro_domicilio'           => $request->input('retiro_domicilio_hidden'),
            'retiro_localidad'           => $request->input('retiro_localidad_hidden'),
            'retiro_franja'              => $request->input('retiro_franja_hidden'),
            'mercaderia_largo'           => $request->input('mercaderia_largo_hidden'),
            'mercaderia_alto'            => $request->input('mercaderia_alto_hidden'),
            'mercaderia_ancho'           => $request->input('mercaderia_ancho_hidden'),
            'mercaderia_peso'            => $request->input('mercaderia_peso_hidden'),
            'mercaderia_cantidad'        => $request->input('mercaderia_cantidad_hidden'),
            'mercaderia_descripcion'     => $request->input('mercaderia_descripcion_hidden'),
            'embalaje'                   => $request->input('embalaje_hidden'),
            'mercaderia_valor_declarado' => $request->input('mercaderia_valor_declarado_hidden'),
            'mercaderia_delicada'        => $request->input('mercaderia_delicada'),
            'embalaje_cajon'             => $request->input('embalaje_cajon'),
            'destinatario_nombre'        => $request->input('destinatario_nombre'),
            'destinatario_doc'           => $request->input('destinatario_doc'),
            'destinatario_telefono'      => $request->input('destinatario_telefono'),
            'destinatario_mail'          => $request->input('destinatario_mail'),
            'destinatario_domicilio'     => $request->input('destinatario_domicilio'),
            'destinatario_localidad'     => $request->input('destinatario_localidad'),
            'destinatario_franja'        => $request->input('destinatario_franja'),
        ];
        $data['retiroData'] = $retiroData;

        \Log::info("Valor de embalaje recibido: " . $request->input('embalaje_hidden'));
        \Log::info("Valor de embalaje cajón recibido: " . $request->input('embalaje_cajon'));
    }

    // 4) Construir el mailable
    $mailable = new PresupuestoMail($data);

    // 5) Asignar correos CC si corresponde
    $ccEmails = null;
    if ($request->has('retirar_domicilio') && $request->input('retirar_domicilio')) {
        $sucId = $data['sucursal_id_origen'] ?? null;
        if ($sucId && isset($this->sucursalEmails[$sucId])) {
            $ccEmails = $this->sucursalEmails[$sucId];
        }
    }

    // 6) Enviar el correo, con CC si corresponde
    if ($ccEmails) {
        Mail::to($data['clienteMail'] ?? 'info@brio.com.ar')
            ->cc($ccEmails)
            ->send($mailable);
    } else {
        Mail::to($data['clienteMail'] ?? 'info@brio.com.ar')
            ->send($mailable);
    }

    if (!empty($data['retiroData'])) {
        Mail::to('retiros@brio.com.ar')
            ->send(new RetiroSolicitadoMail($data));
    }

    // 7) Retornar JSON
    return response()->json([
        'ok'      => true,
        'mensaje' => 'Correo enviado e inserción realizada en la base (con detalle).'
    ]);
}




}
