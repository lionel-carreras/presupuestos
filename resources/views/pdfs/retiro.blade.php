<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Formulario de Retiros</title>
  <style>
    body {
      font-family: 'DejaVu Sans', sans-serif;
      font-size: 12px;
      line-height: 1.4;
      margin: 20px;
    }
    .center {
      text-align: center;
      font-weight: bold;
      margin-bottom: 20px;
    }
    .section {
      margin-top: 20px;
      margin-bottom: 20px;
    }
    .label {
      font-weight: bold;
    }
    .field {
      margin-bottom: 5px;
    }
    .checkbox {
      margin-right: 15px;
    }
    .small-note {
      font-size: 10px;
      font-style: italic;
    }
    .line {
      margin-bottom: 10px;
    }
    .header-logo {
      text-align: right;
      margin-bottom: 100px;
    }
  </style>
</head>
<body>

        <!-- Logo en la parte superior derecha -->
        <div style="text-align: right;">
            <img src="{{ $logoBase64 }}" alt="Logo Expreso Brio" style="height: 100px;">
        </div>


  <!-- Título del formulario -->
  <h4><div class="center">FORMULARIO DE RETIROS</div></h4>
<br>
<hr>
  <!-- Flete -->
<div class="section">
    <div class="field">
      <span class="label">EL FLETE SERÁ ABONADO EN:</span>
      @if(isset($pago_en) && strtolower($pago_en) == 'origen')
        <span class="checkbox">&#10003; ORIGEN</span>
        <span class="checkbox">&#9744; DESTINO</span>
      @elseif(isset($pago_en) && strtolower($pago_en) == 'destino')
        <span class="checkbox">&#9744; ORIGEN</span>
        <span class="checkbox">&#10003; DESTINO</span>
      @else
        <span class="checkbox">&#9744; ORIGEN</span>
        <span class="checkbox">&#9744; DESTINO</span>
      @endif
    </div>

  </div>
<hr>
<br>
  <!-- Datos del remitente -->
  <div class="section">
    <div class="label">DATOS DEL REMITENTE</div>
    <div class="field"><span class="label">Nombre / Razón Social:</span> {{ $remitente_nombre ?? 'Haga clic o pulse aquí para escribir texto.' }}</div>
    <div class="field"><span class="label">Teléfono de contacto:</span> {{ $remitente_telefono ?? 'Haga clic o pulse aquí para escribir texto.' }}</div>
    <div class="field"><span class="label">E-mail de contacto:</span> {{ $remitente_mail ?? 'Haga clic o pulse aquí para escribir texto.' }}</div>
    <div class="field"><span class="label">CUIT / DNI:</span> {{ $remitente_doc ?? 'Haga clic o pulse aquí para escribir texto.' }}</div>
    <div class="field"><span class="label">Dirección de retiro:</span> {{ $retiro_domicilio ?? 'Haga clic o pulse aquí para escribir texto.' }}</div>
    <div class="field"><span class="label">Localidad:</span> {{ $retiro_localidad ?? 'Haga clic o pulse aquí para escribir texto.' }}</div>
    <div class="field"><span class="label">Franja horaria para retiro:</span> {{ $retiro_franja ?? 'Haga clic o pulse aquí para escribir texto.' }}</div>
  </div>
  <hr>
  <br>
  <!-- Mercadería a transportar -->
  <div class="section">
    <div class="label">MERCADERIA A TRANSPORTAR</div>
    <div class="field">
      <span class="label">Medidas (m o cm):</span><br>
      LARGO: {{ $mercaderia_largo ?? 'Haga clic o pulse aquí para escribir texto.' }}<br>
      ALTO: {{ $mercaderia_alto ?? 'Haga clic o pulse aquí para escribir texto.' }}<br>
      ANCHO: {{ $mercaderia_ancho ?? 'Haga clic o pulse aquí para escribir texto.' }}
    </div>
    <div class="field">
      <span class="label">Peso (Kg):</span> {{ $mercaderia_peso ?? 'Haga clic o pulse aquí para escribir texto.' }}
    </div>
    <div class="field">
      <span class="label">Tipo de bulto:</span> {{ $mercaderia_descripcion }}

    </div>

    <!-- caja, pallet, irregular tilda el que corresponde -->
    <div class="field">
        <span class="label">Tipo de mercadería:</span><br>
        <span class="checkbox">
          {!! (isset($embalaje) && strpos($embalaje, 'caja') !== false) ? '&#10003;' : '&#9744;' !!}
          CAJA
        </span>
        <span class="checkbox">
          {!! (isset($embalaje) && strpos($embalaje, 'pallet') !== false) ? '&#10003;' : '&#9744;' !!}
          PALLET
        </span>
        <span class="checkbox">
          {!! (isset($embalaje) && strpos($embalaje, 'irregular') !== false) ? '&#10003;' : '&#9744;' !!}
          BULTO IRREGULAR
        </span>
      </div>

      <!--------------------------------------------------------------------------------------->


    <div class="field">
      <span class="label">Cantidad:</span> {{ $mercaderia_cantidad ?? 'Haga clic o pulse aquí para escribir texto.' }}
    </div>
    <div class="field">
      <span class="label">Valor declarado total expresado en pesos (ARS):</span> {{ $mercaderia_valor_declarado ?? 'Haga clic o pulse aquí para escribir texto.' }}
    </div>
  </div>
  <hr>
  <div class="field">
    <span>El embalaje de la mercadería a transportar debe cubrir la totalidad de la misma. Deberá impedir que se desplace y/o extravíe el contenido que lo integra</span>
  </div>
  <br>
  <!-- Mercadería de naturaleza delicada -->
  <div class="section">
    <div class="label">MERCADERÍA DE NATURALEZA DELICADA</div>
    <div class="field">
  <span class="label">Mercadería de naturaleza delicada:</span><br>
  {!! (isset($mercaderia_delicada) && strpos($mercaderia_delicada, 'CRISTALERIA/VIDRIOS/ESPEJOS') !== false) ? '&#10003;' : '&#9744;' !!}
  CRISTALERIA/VIDRIOS/ESPEJOS<br>
  {!! (isset($mercaderia_delicada) && strpos($mercaderia_delicada, 'RIELES/PERFILES/TUBOS DE ALUMINIO Y/O PVC') !== false) ? '&#10003;' : '&#9744;' !!}
  RIELES/PERFILES/TUBOS DE ALUMINIO Y/O PVC<br>
  {!! (isset($mercaderia_delicada) && strpos($mercaderia_delicada, 'BULTOS DE ALUMINIO') !== false) ? '&#10003;' : '&#9744;' !!}
  BULTOS DE ALUMINIO<br>
  {!! (isset($mercaderia_delicada) && strpos($mercaderia_delicada, 'MUEBLES') !== false) ? '&#10003;' : '&#9744;' !!}
  MUEBLES<br>
  {!! (isset($mercaderia_delicada) && strpos($mercaderia_delicada, 'HORNOS') !== false) ? '&#10003;' : '&#9744;' !!}
  HORNOS<br>
  {!! (isset($mercaderia_delicada) && strpos($mercaderia_delicada, 'COCINAS') !== false) ? '&#10003;' : '&#9744;' !!}
  COCINAS<br>
  {!! (isset($mercaderia_delicada) && strpos($mercaderia_delicada, 'HELADERAS') !== false) ? '&#10003;' : '&#9744;' !!}
  HELADERAS<br>
  {!! (isset($mercaderia_delicada) && strpos($mercaderia_delicada, 'MAQUINARIA') !== false) ? '&#10003;' : '&#9744;' !!}
  MAQUINARIA<br>
  {!! (isset($mercaderia_delicada) && strpos($mercaderia_delicada, 'VEHÍCULOS') !== false) ? '&#10003;' : '&#9744;' !!}
  VEHÍCULOS<br>
  {!! (isset($mercaderia_delicada) && strpos($mercaderia_delicada, 'CERÁMICOS') !== false) ? '&#10003;' : '&#9744;' !!}
  CERÁMICOS<br>
  {!! (isset($mercaderia_delicada) && strpos($mercaderia_delicada, 'VASIJAS CERÁMICAS/VASIJAS BARRO') !== false) ? '&#10003;' : '&#9744;' !!}
  VASIJAS CERÁMICAS/VASIJAS BARRO<br>
  {!! (isset($mercaderia_delicada) && strpos($mercaderia_delicada, 'BULTOS DE PORCELANA') !== false) ? '&#10003;' : '&#9744;' !!}
  BULTOS DE PORCELANA<br>
</div>
<hr>
  <br>
    <div class="field">
      Si seleccionó alguno de los ítems anteriores responder lo siguiente:
    </div>
    <div class="field">
        <span class="label">¿La carga se encuentra embalada en un cajón de madera cerrado, que cubre el 100% de la misma?</span><br>
        <span class="checkbox">
          {!! (isset($embalaje_cajon) && $embalaje_cajon == 'SI') ? '&#10003;' : '&#9744;' !!}
          SI
        </span>
        <span class="checkbox">
          {!! (isset($embalaje_cajon) && $embalaje_cajon == 'NO') ? '&#10003;' : '&#9744;' !!}
          NO
        </span>
      </div>
      <hr>
      <br>
  <!-- Datos del destinatario -->
  <div class="section">
    <div class="label">DATOS DEL DESTINATARIO</div>
    <div class="field"><span class="label">Nombre / Razón Social:</span> {{ $destinatario_nombre ?? 'Haga clic o pulse aquí para escribir texto.' }}</div>
    <div class="field"><span class="label">Teléfono de contacto:</span> {{ $destinatario_telefono ?? 'Haga clic o pulse aquí para escribir texto.' }}</div>
    <div class="field"><span class="label">E-mail de contacto:</span> {{ $destinatario_mail ?? 'Haga clic o pulse aquí para escribir texto.' }}</div>
    <div class="field"><span class="label">CUIT / DNI:</span> {{ $destinatario_doc ?? 'Haga clic o pulse aquí para escribir texto.' }}</div>
    <div class="field"><span class="label">Dirección de entrega:</span> {{ $destinatario_domicilio ?? 'Haga clic o pulse aquí para escribir texto.' }}</div>
    <div class="field"><span class="label">Localidad:</span> {{ $destinatario_localidad ?? 'Haga clic o pulse aquí para escribir texto.' }}</div>
    <div class="field"><span class="label">Franja horaria para entrega:</span> {{ $destinatario_franja ?? 'Haga clic o pulse aquí para escribir texto.' }}</div>

  </div>

</body>
</html>
