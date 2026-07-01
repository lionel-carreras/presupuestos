<!-- resources/views/mails/presupuestoConfirmado.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Presupuesto Expreso Brio</title>
</head>
<body style="font-family: Arial, sans-serif;">

    <p><strong>Estimado <b>{{ $clienteNombre }}</b></strong>,<span style="color: #05a064;"> Su presupuesto ha sido confirmado ✅</p>
    <p><span style="color: #05a064;">- No debe responder este correo -</p></span>
    <p> 👇🏻 Se adjunta  <span style="color: #05a064;"><b>📝 PRESUPUESTO FORMAL</b></p></span>

    <p>
      La información que se tomará como válida para confeccionar la factura será la declarada
      en el REMITO con el cual despacha la mercadería,<span style="background: #10eaf1;"><b>aclarando también quién abona el envío
      (origen o destino) de no estar detallado,<br>
       se tomará como flete destino.</b></span>
    </p>

    <hr>
    <p>
        <span style="color: #05a064;"><strong>⚠ IMPORTANTE PARA CONTINUAR CON LA GESTIÓN DEL ENVÍO</strong><br></span>
      👉🏻 Una vez coordinado el retiro con la Sucursal correspondiente ( quien confirmará el retiro respondiendo este correo);<br>
        La mercadería deberá estar <b>disponible para su retiro</b> en el domicilio Origen sin excepción. Ver <span style="background: #10eaf1;"> <b> INFO RETIROS</b></span>
      👉🏻 Deberá incluir un REMITO. Ver <span style="background: #10eaf1;"><b>REMITO TIPO</b></span>
      👉🏻 Deberá imprimir y adjuntar el <span style="color: #00c479;"><b>Presupuesto Formal</b></span> al <span style="color: #05a064;"><b> Remito </b></span>,<br>
       para que pueda ser respaldado al momento de facturación.<br>

      <span style="color: #05a064;"><b>🕒 Su presupuesto tendrá una validéz de 72Hs. hábiles.</b> Pasado ese tiempo debe solicitar una actualización de fecha<br>
         💲<b>El pago podrá ser realizado una vez despachado el envío.</b> Para consultas Comunicarse con Atención al cliente vía Whatsapp al<br>
            +54 9 341 1209-6437 o al +54 9 341 245-7755.

         ✅<b> Nuestros precios se calculan de depósito a depósito.</b> El servicio puerta a puerta (retiro y entrega en domicilio) no tiene <br>
            cargos extra</span>
    </p>
    <hr>
    <p>
      Quedamos a disposición ante cualquier consulta, si tiene la necesidad de responder este correo por favor siempre responder a todas las <br>
      casillas de correo electrónico sumadas en copia.
      <br>
      Saludos cordiales,
    </p>

    <p>

     <img src="{{ asset('img/logo.png') }}" alt="Logo Expreso Brio" style="height: 100px;"><br>
      <em>Expreso Brio</em> | Presupuestos <br>
      Av. Ing. Acevedo 2949 (Rosario - 2000)<br>
      ---- 📞 0810-888-2746 📞 ----<br>
      <www class="brio">brio.com.ar</www>
    </p>
</body>
</html>
