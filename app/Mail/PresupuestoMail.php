<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use PDF; // alias de barryvdh/laravel-dompdf
use Carbon\Carbon;

class PresupuestoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $clienteNombre;
    public $codigoValidacion;
    public $fechaDesde;
    public $tarifasola;
    public $flete;
    public $iva;
    public $total;
    public $presupuestoID;

    // Variable opcional para datos del retiro
    public $retiroData;

    /**
     * Recibe un array $data con todas las variables necesarias.
     */
    public function __construct($data)
    {
        // Asignar todo el array recibido a la propiedad data
        $this->data = $data;

        // Parsear y formatear la fecha
        $rawDate = $data['fechaDesde'] ?? now()->format('d/m/Y');
        $parsedDate = Carbon::createFromFormat('d/m/Y', $rawDate);
        $this->data['fechaDesde'] = $parsedDate
            ->locale('es')
            ->translatedFormat('l, d \\d\\e F Y');

        // Asignar otras variables al array, si no están ya definidas
        $this->data['clienteNombre'] = $data['clienteNombre'] ?? 'Estimado cliente';
        $this->data['presupuestoID'] = $data['presupuestoID'] ?? '000000';
        $this->data['tarifasola']    = $data['tarifasola']    ?? 0;
        $this->data['flete']         = $data['flete']         ?? 0;
        $this->data['iva']           = $data['iva']           ?? 0;
        $this->data['total']         = $data['total']         ?? 0;
        $this->data['mercaderia_descripcion'] = $data['mercaderia_descripcion']
            ?? $data['mercaderia_descripcion_hidden']
            ?? ($data['retiroData']['mercaderia_descripcion'] ?? 'Sin descripcion');

        // Asignar embalaje_cajon a una propiedad independiente
        $this->embalaje_cajon = $data['embalaje_cajon'] ?? null;
    }

    /**
     * Construye el correo, generando y adjuntando los PDFs.
     */
    public function build()
    {
        // 1) Preparar la imagen en base64 (logo)
        $logoPath = public_path('img/logo.png');
        $logoData = base64_encode(file_get_contents($logoPath));
        $logoBase64 = 'data:image/png;base64,' . $logoData;

        // 2) Generar el PDF principal con la vista 'pdfs.presupuesto'
        $pdf = PDF::loadView('pdfs.presupuesto', [
            'fechaDesde'             => $this->data['fechaDesde'] ?? null,
            'clienteNombre'          => $this->data['clienteNombre'] ?? null,
            'presupuestoID'          => $this->data['presupuestoID'] ?? null,
            'tarifasola'             => $this->data['tarifasola'] ?? null,
            'flete'                  => $this->data['flete'] ?? null,
            'iva'                    => $this->data['iva'] ?? null,
            'total'                  => $this->data['total'] ?? null,
            'logoBase64'             => $logoBase64,
            'mercaderia_descripcion' => $this->data['mercaderia_descripcion'] ?? 'Sin descripcion',
            'mercaderia_largo'       => $this->data['mercaderia_largo'] ?? null,
            'mercaderia_alto'        => $this->data['mercaderia_alto'] ?? null,
            'mercaderia_ancho'       => $this->data['mercaderia_ancho'] ?? null,
            'mercaderia_peso'        => $this->data['mercaderia_peso'] ?? null,
            'mercaderia_cantidad'    => $this->data['mercaderia_cantidad'] ?? null,
            'mercaderia_valor_declarado' => $this->data['mercaderia_valor_declarado'] ?? null,
        ])
        ->setOption('defaultFont', 'DejaVu Sans')
        ->setOption('isRemoteEnabled', true);

        // 3) Armar el correo adjuntando los PDFs existentes y el generado
        $email = $this->subject('Presupuesto Expreso Brio')
                      ->view('mails.presupuestoConfirmado')
                      ->attachData($pdf->output(), 'PresupuestoFormal.pdf', [
                          'mime' => 'application/pdf',
                      ]);

        // 4) Si existen datos de retiro, adjuntar el PDF de retiro
        if (!empty($this->data['retiroData'])) {
            $pdfRetiro = PDF::loadView('pdfs.retiro', array_merge($this->data['retiroData'], ['logoBase64' => $logoBase64]))
                            ->setOption('defaultFont', 'DejaVu Sans')
                            ->setOption('isRemoteEnabled', true);
            $email->attachData($pdfRetiro->output(), 'Retiro.pdf', [
                'mime' => 'application/pdf',
            ]);
        }

        // 5) Si embalaje_cajon es "NO", adjuntar los PDFs adicionales
        if ($this->embalaje_cajon === 'NO') {
            $email->attach(public_path('pdfs/NOTA EMBALAJE ORIGEN.pdf'));
            $email->attach(public_path('pdfs/NOTA EMBALAJE DESTINO.pdf'));
        }

        return $email;
    }
}
