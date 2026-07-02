<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Nuevo retiro solicitado</title>
</head>
<body style="font-family: Arial, sans-serif; color: #222;">
    <h2 style="color: #05a064;">Nuevo retiro solicitado</h2>

    <p>
        Se genero una solicitud de retiro desde la calculadora web.
    </p>

    <h3>Presupuesto</h3>
    <table cellpadding="6" cellspacing="0" border="1" style="border-collapse: collapse;">
        <tr>
            <td><strong>Codigo de validacion</strong></td>
            <td>{{ $data['presupuestoID'] ?? 'No disponible' }}</td>
        </tr>
        <tr>
            <td><strong>Cliente</strong></td>
            <td>{{ $data['clienteNombre'] ?? 'No disponible' }}</td>
        </tr>
        <tr>
            <td><strong>CUIT / DNI</strong></td>
            <td>{{ $data['clienteCuit'] ?? 'No disponible' }}</td>
        </tr>
        <tr>
            <td><strong>Email cliente</strong></td>
            <td>{{ $data['clienteMail'] ?? 'No disponible' }}</td>
        </tr>
        <tr>
            <td><strong>Origen</strong></td>
            <td>{{ $data['origenLocalidad'] ?? 'No disponible' }}</td>
        </tr>
        <tr>
            <td><strong>Destino</strong></td>
            <td>{{ $data['destinoLocalidad'] ?? 'No disponible' }}</td>
        </tr>
        <tr>
            <td><strong>Total</strong></td>
            <td>${{ number_format((float) ($data['total'] ?? 0), 2, ',', '.') }}</td>
        </tr>
    </table>

    <h3>Datos del retiro</h3>
    <table cellpadding="6" cellspacing="0" border="1" style="border-collapse: collapse;">
        <tr>
            <td><strong>Pago en</strong></td>
            <td>{{ $retiro['pago_en'] ?? 'No disponible' }}</td>
        </tr>
        <tr>
            <td><strong>Remitente</strong></td>
            <td>{{ $retiro['remitente_nombre'] ?? 'No disponible' }}</td>
        </tr>
        <tr>
            <td><strong>Telefono remitente</strong></td>
            <td>{{ $retiro['remitente_telefono'] ?? 'No disponible' }}</td>
        </tr>
        <tr>
            <td><strong>Email remitente</strong></td>
            <td>{{ $retiro['remitente_mail'] ?? 'No disponible' }}</td>
        </tr>
        <tr>
            <td><strong>Documento remitente</strong></td>
            <td>{{ $retiro['remitente_doc'] ?? 'No disponible' }}</td>
        </tr>
        <tr>
            <td><strong>Domicilio retiro</strong></td>
            <td>{{ $retiro['retiro_domicilio'] ?? 'No disponible' }}</td>
        </tr>
        <tr>
            <td><strong>Localidad retiro</strong></td>
            <td>{{ $retiro['retiro_localidad'] ?? 'No disponible' }}</td>
        </tr>
        <tr>
            <td><strong>Franja retiro</strong></td>
            <td>{{ $retiro['retiro_franja'] ?? 'No disponible' }}</td>
        </tr>
    </table>

    <h3>Mercaderia</h3>
    <table cellpadding="6" cellspacing="0" border="1" style="border-collapse: collapse;">
        <tr>
            <td><strong>Descripcion</strong></td>
            <td>{{ $retiro['mercaderia_descripcion'] ?? 'No disponible' }}</td>
        </tr>
        <tr>
            <td><strong>Medidas</strong></td>
            <td>
                Largo: {{ $retiro['mercaderia_largo'] ?? '-' }} cm,
                Alto: {{ $retiro['mercaderia_alto'] ?? '-' }} cm,
                Ancho: {{ $retiro['mercaderia_ancho'] ?? '-' }} cm
            </td>
        </tr>
        <tr>
            <td><strong>Peso / cantidad</strong></td>
            <td>{{ $retiro['mercaderia_peso'] ?? '-' }} kg / {{ $retiro['mercaderia_cantidad'] ?? '-' }} bultos</td>
        </tr>
        <tr>
            <td><strong>Valor declarado</strong></td>
            <td>${{ number_format((float) ($retiro['mercaderia_valor_declarado'] ?? 0), 2, ',', '.') }}</td>
        </tr>
        <tr>
            <td><strong>Embalaje</strong></td>
            <td>{{ $retiro['embalaje'] ?? 'No disponible' }}</td>
        </tr>
        <tr>
            <td><strong>Mercaderia delicada</strong></td>
            <td>{{ $retiro['mercaderia_delicada'] ?? 'No disponible' }}</td>
        </tr>
        <tr>
            <td><strong>Cajon de madera</strong></td>
            <td>{{ $retiro['embalaje_cajon'] ?? 'No disponible' }}</td>
        </tr>
    </table>

    <h3>Destinatario</h3>
    <table cellpadding="6" cellspacing="0" border="1" style="border-collapse: collapse;">
        <tr>
            <td><strong>Nombre</strong></td>
            <td>{{ $retiro['destinatario_nombre'] ?? 'No disponible' }}</td>
        </tr>
        <tr>
            <td><strong>Documento</strong></td>
            <td>{{ $retiro['destinatario_doc'] ?? 'No disponible' }}</td>
        </tr>
        <tr>
            <td><strong>Telefono</strong></td>
            <td>{{ $retiro['destinatario_telefono'] ?? 'No disponible' }}</td>
        </tr>
        <tr>
            <td><strong>Email</strong></td>
            <td>{{ $retiro['destinatario_mail'] ?? 'No disponible' }}</td>
        </tr>
        <tr>
            <td><strong>Domicilio</strong></td>
            <td>{{ $retiro['destinatario_domicilio'] ?? 'No disponible' }}</td>
        </tr>
        <tr>
            <td><strong>Localidad</strong></td>
            <td>{{ $retiro['destinatario_localidad'] ?? 'No disponible' }}</td>
        </tr>
        <tr>
            <td><strong>Franja entrega</strong></td>
            <td>{{ $retiro['destinatario_franja'] ?? 'No disponible' }}</td>
        </tr>
    </table>
</body>
</html>
