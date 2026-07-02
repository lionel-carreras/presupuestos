<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RetiroSolicitadoMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public array $data)
    {
    }

    public function build()
    {
        $presupuestoId = $this->data['presupuestoID'] ?? 'sin codigo';

        return $this->subject('Nuevo retiro solicitado - Presupuesto ' . $presupuestoId)
            ->view('mails.retiroSolicitado', [
                'data' => $this->data,
                'retiro' => $this->data['retiroData'] ?? [],
            ]);
    }
}
