<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Presupuesto Formal</title>
    <style>
        @page {
            margin: 18px 34px 20px;
        }

        body {
            color: #2b2b2f;
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            line-height: 1.34;
            margin: 0;
        }

        .top {
            height: 116px;
            position: relative;
        }

        .dot-area {
            border-radius: 50%;
            border-top: 2px dotted #d5d9dd;
            border-left: 2px dotted #d5d9dd;
            height: 72px;
            left: -42px;
            position: absolute;
            top: 6px;
            width: 245px;
        }

        .green-line {
            border-top: 2px solid #18aa58;
            border-radius: 50%;
            height: 72px;
            left: -36px;
            position: absolute;
            top: 33px;
            width: 520px;
        }

        .logo {
            height: 76px;
            position: absolute;
            right: 14px;
            top: 18px;
        }

        h1 {
            font-size: 27px;
            letter-spacing: 0;
            margin: 4px 0 24px;
            text-align: center;
        }

        .date {
            font-size: 12px;
            margin: -12px 0 26px;
            text-align: right;
        }

        .intro {
            margin: 0 14px 18px;
        }

        .intro p {
            margin: 0 0 12px;
        }

        .cost-box {
            border: 1.6px solid #55bf70;
            border-radius: 10px;
            font-size: 15px;
            font-weight: bold;
            line-height: 1.22;
            margin: 0 18px 18px;
            padding: 16px 22px 12px;
            text-align: center;
        }

        .validation {
            font-size: 18px;
            font-weight: bold;
            margin: 0 0 18px;
            text-align: center;
        }

        .validation span {
            color: #05a064;
        }

        .section-title {
            color: #05a064;
            font-size: 13px;
            font-weight: bold;
            margin: 0 0 5px;
        }

        .notice {
            border-top: 1px solid #989898;
            margin-top: 4px;
            padding-top: 8px;
        }

        .notice p {
            margin: 0 0 7px;
        }

        .notice ul {
            margin: 0 0 8px 17px;
            padding: 0;
        }

        .notice li {
            margin-bottom: 3px;
        }

        .small {
            font-size: 10.2px;
            line-height: 1.28;
        }

        .thanks {
            margin-top: 16px;
        }
    </style>
</head>
<body>
@php
    $cantidad = $mercaderia_cantidad ?? null;
    $cantidadTexto = $cantidad ? $cantidad . ' ' . ((int) $cantidad === 1 ? 'bulto' : 'bultos') : 'la mercaderia';
    $descripcion = trim((string) ($mercaderia_descripcion ?? ''));
    $largo = $mercaderia_largo ?? null;
    $alto = $mercaderia_alto ?? null;
    $ancho = $mercaderia_ancho ?? null;
    $medidas = ($largo || $alto || $ancho)
        ? trim(($largo ?? '-') . 'x' . ($ancho ?? '-') . 'x' . ($alto ?? '-') . ' cm')
        : null;
    $detalleMercaderia = trim($cantidadTexto . ' ' . $descripcion . ($medidas ? ' (' . $medidas . ')' : ''));
@endphp

<div class="top">
    <div class="dot-area"></div>
    <div class="green-line"></div>
    <img src="{{ $logoBase64 }}" alt="Logo Expreso Brio" class="logo">
</div>

<h1>PRESUPUESTO FORMAL</h1>

<div class="date">{{ $fechaDesde }}</div>

<div class="intro">
    <p><strong>Estimado Cliente:</strong></p>
    <p>
        Tenemos el agrado de dirigirnos a Ud. a fin de enviarle por medio de la presente nuestro presupuesto
        para los servicios solicitados:
    </p>
</div>

<div class="cost-box">
    El costo de envio por {{ $detalleMercaderia ?: 'la mercaderia declarada' }} es de
    ${{ number_format((float) $tarifasola, 2, ',', '.') }}
    + seguro (1% sobre Valor Declarado, cuando el mismo sea mayor a $500000, si es menor a ese importe se abonan $5000)
    + IVA.
</div>

<div class="validation">
    CODIGO DE VALIDACION: <span>{{ $presupuestoID }}</span>
</div>

<div class="notice small">
    <p>
        <strong class="section-title">IMPORTANTE:</strong>
        SI LA MERCADERIA TRASLADADA DIFIERE EN ALGUN MODO DE LA PRESUPUESTADA, EL COSTO DEL ENVIO SE VERA AFECTADO
        Y ESTE PRESUPUESTO PERDERA VALIDEZ.
    </p>

    <p>
        <strong>Mercaderia declarada:</strong> {{ $descripcion ?: 'Sin descripcion declarada' }}.
        <strong>Cantidad:</strong> {{ $cantidad ?? '-' }}.
        <strong>Peso total:</strong> {{ $mercaderia_peso ?? '-' }} kg.
        <strong>Valor declarado:</strong> ${{ number_format((float) ($mercaderia_valor_declarado ?? 0), 2, ',', '.') }}.
    </p>

    <p class="section-title">CONDICIONES IMPORTANTES</p>
    <ul>
        <li>El envio debera presentar su respectivo remito con domicilio, localidad, telefono, CUIT o DNI de destino y origen, cargo de flete y valor declarado.</li>
        <li>La mercaderia debera contar con embalaje adecuado. De no contar con embalaje adecuado, se debera firmar una nota de embalaje deficiente, sin excepcion.</li>
        <li>El monto presupuestado se refiere al traslado de deposito a deposito. Retiro y entrega a domicilio quedan bonificados y sujetos a disponibilidad tecnica, geografica y climatologica.</li>
    </ul>

    <p>
        <strong>ESTA COTIZACION NO INCLUYE:</strong>
        medios de elevacion de carga en origen y destino, demoras de carga y descarga, ni condicion especial de entrega en deposito fiscal.
    </p>

    <p>
        Recuerde mencionar que posee presupuesto y adjuntar una copia al remito cuando despache la mercaderia en origen,
        para que se respete al momento de la facturacion.
    </p>

    <p>
        SIN ESTA CONFIRMACION CARECERA DE VALIDEZ Y NO SE ACEPTARAN RECLAMOS POR NOTAS DE CREDITO.
        El presupuesto tiene validez de 72hs habiles.
    </p>
</div>

<p class="thanks">
    Desde ya muchas gracias,<br>
    Saludos cordiales.
</p>
</body>
</html>
