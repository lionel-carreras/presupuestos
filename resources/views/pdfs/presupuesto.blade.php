<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Presupuesto Formal</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif; /* Soporta caracteres Unicode */
            font-size: 12px;
            margin: 30px;
        }
    </style>
</head>
<body>

    <!-- 1) LOGO ARRIBA A LA DERECHA -->
    <div style="text-align: right;">
        <img src="{{ $logoBase64 }}" alt="Logo Expreso Brio" style="height: 100px;">
    </div>

    <!-- 2) FECHA EN LA SIGUIENTE LÍNEA, TAMBIÉN A LA DERECHA -->
    <div style="text-align: right; margin-top: 5px;">
        <strong>{{ $fechaDesde }}</strong>
    </div>

    <!-- 3) TÍTULO A LA IZQUIERDA (NUEVA LÍNEA) -->
    <h3 style="margin-top: 10px;">PRESUPUESTO FORMAL</h3>
<p><strong>Estimado/a {{ $clienteNombre }}:</strong></p>
<p>
    Tenemos el agrado de dirigirnos a Ud. a fin de enviarle por medio de la presente
    nuestro presupuesto para los servicios solicitados:
</p>

<p><strong>CÓDIGO DE VALIDACIÓN:</strong><b style="color: #05a064;"> {{ $presupuestoID }}</b></p>

<p>
    El costo del envío es de
    <strong>${{ number_format($tarifasola, 2) }}</strong>
    + seguro (1% sobre Valor Declarado)
    + IVA.
</p>
<hr>
<h4 class="importante" style="color: #05a064;">IMPORTANTE ⚠</h4>
<ol>
    <li>
        El envío deberá presentar su respectivo REMITO, aclarando:<br>
        * Domicilio, localidad, teléfono, CUIT o DNI de destino y origen.<br>
        * Aclaración del cargo de flete a abonar por remitente o destinatario.<br>
        * Valor declarado.
    </li>
    <li>
        La mercadería deberá contar con embalaje adecuado, si cuenta con vidrio, carteles
        identificatorios y embalaje correspondiente a ese tipo de mercadería, para así
        facilitar su traslado y manipulación, como también rótulos identificatorios.
        De no contar con embalaje adecuado, se deberá firmar una nota de embalaje deficiente,
        <strong>SIN EXCEPCIÓN</strong>.
    </li>
    <li>
        El monto presupuestado se refiere al traslado de Depósito a Depósito, siendo el
        retiro y entrega a domicilio bonificado y sujeto a la disponibilidad técnica,
        geográfica y climatológica.
    </li>
</ol>

<p>
    <strong>ESTA COTIZACIÓN NO INCLUYE</strong><br>
    * MEDIOS DE ELEVACIÓN DE CARGA EN ORIGEN Y DESTINO.<br>
    * DEMORAS DE CARGA Y DESCARGA.<br>
    * CONDICIÓN ESPECIAL DE ENTREGA EN DEPÓSITO FISCAL.
</p>

<hr>

<p>
    <strong style="color: #05a064;">IMPORTANTE:</strong> SI LA MERCADERÍA TRASLADADA DIFIERE EN ALGÚN MODO DE LA
    PRESUPUESTADA, EL COSTO DEL ENVÍO SE VERÁ AFECTADO Y ESTE PRESUPUESTO
    PERDERÁ VALIDEZ.<br><br>

    Recuerde mencionar que posee presupuesto y adjuntar una copia al
    remito cuando despache la mercadería en el origen, para que le respeten
    el mismo al momento de la facturación.<br><br>

    SIN ESTA CONFIRMACIÓN CARECERÁ DE VALIDEZ Y NO SE ACEPTARÁN
    RECLAMOS POR NOTAS DE CRÉDITO. El presupuesto tiene validez de
    72hs hábiles.
</p><br>

<p>
    Desde ya muchas gracias,<br>
    Saludos cordiales.
</p>

</body>
</html>
