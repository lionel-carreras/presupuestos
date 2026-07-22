<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
  <title>Expreso Brio</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">

  <style>
    .custom-title {
      font-family: 'Roboto Condensed', sans-serif;
      color: #00c479;

    }
    /* Clase para títulos más grandes en las tarjetas */
    .label-title {
      font-size: 1.5rem;
      font-weight: bold;
      font-size: 18px;
    }
    .toggle-on.custom-green {
    background-color: #00c479 !important;
    border-color: #00c479 !important;
    }
  </style>
</head>
<body style="padding-bottom: 2.5rem;">
    @include('clientenuevo.modal')
    
  <div class="container mt-5">
    <h3 class="text-center mb-4 custom-title">
       <img src="{{ asset('img/logo.png') }}"style="height: 130px;"><br><br>
      <b>Presupuesto online</b>
     <!--  <img src="{{ asset('img/logo.png') }}"style="height: 80px;">-->
    </h3><br>
    <form id="formPresupuesto" method="POST" action="{{ route('calcular') }}">
      @csrf
      <!-- Datos del Solicitante -->
      <div class="row justify-content-center">
        <div class="col-md-8 mb-5">
          <div class="card">
            <div class="card-header text-center custom-title label-title">
              Datos del solicitante
            </div>
            <div class="card-body">
              <!-- Campo CUIT con búsqueda en tiempo real -->
              <div class="mb-3 position-relative">
                <input type="text" id="clientecuit" name="cliente_cuit" class="form-control"
                  placeholder="Ingrese CUIT sin guiones" autocomplete="off" required>
                <div id="dropdownClientes" class="dropdown-menu"
                  style="display: none; position: absolute; width: 100%;"></div>
              </div>
              <!-- Campo nombre que se autocompleta -->
              <div class="mb-3">
                <input type="text" id="clientenombre" name="cliente_nombre" class="form-control"
                  placeholder="Nombre o Razón Social" autocomplete="off" required>
              </div>
              <!-- Campo email -->
              <div class="mb-3">
                <input type="email" id="clientemail" name="cliente_mail" class="form-control"
                  placeholder="Email para recibir presupuesto" autocomplete="off" required>
              </div>

              <!-- Campo oculto para almacenar el ClienteID real -->
              <input type="hidden" id="cliente_id" name="cliente_id">
              <!-- Campos ocultos para SucursalID y TarifaID -->
              <input type="hidden" id="sucursal_id_origen" name="sucursal_id_origen">
              <input type="hidden" id="sucursal_id_destino" name="sucursal_id_destino">
              <input type="hidden" id="tarifa_id" name="tarifa_id">
            </div>
          </div>
        </div>
         <!-- Nota y botón de envío -->
      <div class="mb-5 text-center">
        <p class="text-muted fst-italic">
          <i class="fas fa-info-circle me-2"></i>
          <span class="fw-bold custom-title">Nota:</span>
          <b> Presupuesto válido hasta 72Hs hábiles luego de su envío, pasado ese lapso deberá generar uno nuevo!!</b>
        </p>
      </div>
      </div>




       <!-- check retiro -->
      <div class="col-md-12 mb-3 d-flex justify-content-end align-items-center">
        <label for="retirarDomicilio" class="me-2 mb-0">
          Solicitas retiro a domicilio?
        </label>

        <input
          type="checkbox"
          id="retirarDomicilio"
          name="retirar_domicilio"
          data-toggle="toggle"
          data-on="Si"
          data-off="No"
          data-onstyle="success"
          data-offstyle="danger"
          data-size="sm"
        >
      </div>


      <!-- Datos del Envío -->
      <div class="col-md-12 mb-3">
        <div class="card">
          <div class="card-header text-center custom-title label-title">
            Datos del envío
          </div>
          <div class="card-body">
            <div class="row">
              <!-- Origen -->
              <div class="col-6 mb-3">
                <input type="text" id="cporigen" name="cp_origen" class="form-control" placeholder="Ingrese Localidad o Cod. Postal origen" autocomplete="off" required>
                <input type="hidden" id="codigo_postal_origen" name="cp_origen">
                <div id="resultados" class="dropdown-menu" style="display: none; position: absolute;"></div>
              </div>
              <!-- Destino -->
              <div class="col-6 mb-3">
                <input type="text" id="cpdestino" name="cp_destino" class="form-control" placeholder="Ingrese Nombre o Cod. Postal destino" autocomplete="off" required>
                <input type="hidden" id="codigo_postal_destino" name="cp_destino">
                <div id="resultados2" class="dropdown-menu" style="display: none; position: absolute;"></div>
              </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3">
                  <input type="number" id="cantidad" name="cantidad" class="form-control" placeholder="Cantidad" required>
                </div>
                <div class="col-md-9">
                    <input type="text" id="descripcion_sinretiro" name="descripcion_envio" class="form-control" placeholder="Descripción del Envío" required>
                </div>
              </div>

            <!-- Dimensiones -->
            <div class="row mb-3">
              <div class="col-md-4">
                <label for="alto" class="form-label custom-title">Alto (cm)</label>
                <input type="number" id="alto" name="alto" class="form-control" placeholder="Ej. 10" required>
              </div>
              <div class="col-md-4">
                <label for="ancho" class="form-label custom-title">Ancho (cm)</label>
                <input type="number" id="ancho" name="ancho" class="form-control" placeholder="Ej. 15" required>
              </div>
              <div class="col-md-4">
                <label for="largo" class="form-label custom-title">Largo (cm)</label>
                <input type="number" id="largo" name="largo" class="form-control" placeholder="Ej. 30" required>
              </div>
            </div>
            <!-- Peso y Valor -->
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="kilos" class="form-label custom-title">Peso Total (Kg)</label>
                <input type="number" id="kilos" name="kilos" class="form-control" placeholder="Peso total de bultos Ej. 30" required>
              </div>
              <div class="col-md-6 mb-3">
                <label for="valor" class="form-label custom-title">Valor Declarado</label>
                <div class="input-group">
                  <span class="input-group-text">$</span>
                  <input type="number" id="valor" name="valor" class="form-control" placeholder="Ej. 1000 (valor mínimo)" required>
                  <span class="input-group-text">.00</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>



      <div style="display:none;">
        <input type="hidden" id="pago_en_hidden" name="pago_en">
        <input type="hidden" id="tipoBulto_hidden" name="tipo_bulto">
        <input type="hidden" id="remitente_nombre_hidden" name="remitente_nombre">
        <input type="hidden" id="remitente_telefono_hidden" name="remitente_telefono">
        <input type="hidden" id="remitente_mail_hidden" name="remitente_mail">
        <input type="hidden" id="remitente_doc_hidden" name="remitente_doc">
        <input type="hidden" id="retiro_domicilio_hidden" name="retiro_domicilio">
        <input type="hidden" id="retiro_localidad_hidden" name="retiro_localidad">
        <input type="hidden" id="retiro_franja_hidden" name="retiro_franja">
        <input type="hidden" id="mercaderia_largo_hidden" name="mercaderia_largo">
        <input type="hidden" id="mercaderia_alto_hidden" name="mercaderia_alto">
        <input type="hidden" id="mercaderia_ancho_hidden" name="mercaderia_ancho">
        <input type="hidden" id="mercaderia_peso_hidden" name="mercaderia_peso">
        <input type="hidden" id="mercaderia_cantidad_hidden" name="mercaderia_cantidad">
        <input type="hidden" id="mercaderia_descripcion_hidden" name="mercaderia_descripcion">
        <!-- Para mercadería delicada, se usará un único campo que contenga los valores separados por coma -->
        <input type="hidden" id="mercaderia_delicada_hidden" name="mercaderia_delicada">
        <input type="hidden" id="mercaderia_valor_declarado_hidden" name="mercaderia_valor_declarado">
        <!-- Datos del destinatario -->
        <input type="hidden" id="destinatarioNombre_hidden" name="destinatario_nombre">
        <input type="hidden" id="destinatarioCuit_hidden" name="destinatario_doc">
        <input type="hidden" id="destinatarioTelefono_hidden" name="destinatario_telefono">
        <input type="hidden" id="destinatarioMail_hidden" name="destinatario_mail">
        <input type="hidden" id="destinatarioDomicilio_hidden" name="destinatario_domicilio">
        <input type="hidden" id="destinatarioLocalidad_hidden" name="destinatario_localidad">
        <input type="hidden" id="destinatarioFranja_hidden" name="destinatario_franja">
        <!-- Para los checkbox de embalaje (caja, pallet, irregular) -->
        <input type="hidden" id="embalaje_hidden" name="embalaje_hidden">
        <!-- Para la pregunta del cajón de madera, si es SI o NO -->
        <input type="hidden" id="embalaje_cajon_hidden" name="embalaje_cajon">
      </div>


      <div class="text-center">
        <button type="submit" class="btn btn-success btn-lg" style="background-color:#00c479">Enviar</button>
      </div>
    </form>
  </div>
  <br><br>

  <!-------  modal retiros ---->
  @include('modalRetiro.modal')





  <!-- Bootstrap JS, jQuery y SweetAlert -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>


  @include('funciones')

  <footer class="text-center bg-dark text-white" style="position: fixed; right: 0; bottom: 0; left: 0; z-index: 1030; font-size: 0.75rem; line-height: 1.2;">
    <div class="px-2 py-2">
      © 2026 <a class="text-white fw-bold" href="https://kiersys.com/" target="_blank" rel="noopener noreferrer">Kiersys Technologies</a>. Todos los derechos reservados.
    </div>
  </footer>

</body>
</html>
