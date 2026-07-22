 <!-- Modal para datos del retiro -->
 <div class="modal fade" id="retiroModal" tabindex="-1" aria-labelledby="retiroModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="retiroModalLabel">Carga Los datos del retiro</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <!-- Sección Datos remitente -->
          <h5>Datos remitente</h5>
          <!-- Pago en (más chico) -->
          <div class="row mb-3">
            <div class="col-md-4">
              <label for="pagoEn" class="form-label">Seleccionar pago en</label>
              <select id="pagoEn" class="form-control form-control-sm">
                <option value="origen">Origen</option>
                <option value="destino">Destino</option>
              </select>
            </div>
          </div>
          <!-- Fila: Nombre y Cuit / Dni -->
          <div class="row mb-3">
            <div class="col-md-6">

              <input type="text" id="nombreRemitente" class="form-control" placeholder="Nombre o Razón Social" required>
            </div>
            <div class="col-md-6">

              <input type="text" id="docRemitente" class="form-control" placeholder="CUIT / DNI" required>
            </div>
          </div>
          <!-- Fila: Teléfono y Mail -->
          <div class="row mb-3">
            <div class="col-md-6">

              <input type="text" id="telefonoRemitente" class="form-control" placeholder="Teléfono" required>
            </div>
            <div class="col-md-6">

              <input type="email" id="mailRemitente" class="form-control" placeholder="Email" required>
            </div>
          </div>
          <!-- Fila: Domicilio de retiro y Localidad -->
          <div class="row mb-3">
            <div class="col-md-6">

              <input type="text" id="domicilioRetiro" class="form-control" placeholder="Domicilio de retiro" required>
            </div>
            <div class="col-md-6">

              <input type="text" id="localidadRetiro" class="form-control" placeholder="Localidad" required>
            </div>
          </div>
          <!-- Franja horaria -->
          <div class="row mb-3">
            <div class="col-md-4">

              <input type="text" id="franjaHorariaRetiro" class="form-control" placeholder="Franja Horaria de retiro">
            </div>
          </div>
          <hr>
          <!-- Sección Mercadería a transportar -->
          <h5>Mercadería a transportar</h5>
          <!-- Primera fila: largo, alto, ancho, peso, cantidad (todos en una fila) -->
          <div class="row">
            <div class="col-md-2 mb-3">
                <label>Largo</label>
              <input type="number" id="largoModal" class="form-control" placeholder="Largo (cm)"required>
            </div>
            <div class="col-md-2 mb-3">
                <label>Alto</label>
              <input type="number" id="altoModal" class="form-control" placeholder="Alto (cm)" required>
            </div>
            <div class="col-md-2 mb-3">
                <label>Ancho</label>
              <input type="number" id="anchoModal" class="form-control" placeholder="Ancho (cm)" required>
            </div>
            <div class="col-md-2 mb-3">
                <label>Peso Total</label>
              <input type="number" id="pesoModal" class="form-control" placeholder="Peso Total Kg" required >
            </div>
            <div class="col-md-2 mb-3">
                <label>Cantidad</label>
              <input type="number" id="cantidadModal" class="form-control" placeholder="Cantidad" required>
            </div>
          </div>

          <!-- Segunda fila: Descripción a pantalla completa -->
          <div class="row">
            <div class="col-md-12 mb-3">
              <label for="descripcionModal" class="form-label">Descripción</label>
              <textarea id="descripcionModal" class="form-control" rows="2"></textarea>
            </div>
          </div>

          <!-- Tercera fila: Checkboxes y Valor declarado en dos columnas -->
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Tipo de embalaje</label>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="caja" value="caja">
                <label class="form-check-label" for="caja">Caja</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="pallet" value="pallet">
                <label class="form-check-label" for="pallet">Pallet</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="irregular" value="irregular">
                <label class="form-check-label" for="irregular">Irregular</label>
              </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="input-group">
                    <label class="me-3">Valor Declarado</label>
                    <span class="input-group-text">$</span>
                    <input type="number" id="valorDeclaradoModal" class="form-control" placeholder="Valor Declarado" required>
                    <span class="input-group-text">.00</span>
                  </div>
            </div>
          </div>
          <hr>
          <div class="mt-4">
            <h6 style="color: #00c479">MERCADERÍA DE NATURALEZA DELICADA</h6>
          </div>

          <div class="row">
            <!-- Columna Izquierda: primeros 6 checkboxes -->
            <div class="col-md-6">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="delicada1" name="mercaderia_delicada[]" value="CRISTALERIA/VIDRIOS/ESPEJOS">
                <label class="form-check-label" for="delicada1">CRISTALERIA/VIDRIOS/ESPEJOS</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="delicada2" name="mercaderia_delicada[]" value="RIELES/PERFILES/TUBOS DE ALUMINIO Y/O PVC">
                <label class="form-check-label" for="delicada2">RIELES/PERFILES/TUBOS DE ALUMINIO Y/O PVC</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="delicada3" name="mercaderia_delicada[]" value="BULTOS DE ALUMINIO">
                <label class="form-check-label" for="delicada3">BULTOS DE ALUMINIO</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="delicada4" name="mercaderia_delicada[]" value="MUEBLES">
                <label class="form-check-label" for="delicada4">MUEBLES</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="delicada5" name="mercaderia_delicada[]" value="HORNOS">
                <label class="form-check-label" for="delicada5">HORNOS</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="delicada6" name="mercaderia_delicada[]" value="COCINAS">
                <label class="form-check-label" for="delicada6">COCINAS</label>
              </div>
            </div>

            <!-- Columna Derecha: siguientes 6 checkboxes -->
            <div class="col-md-6">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="delicada7" name="mercaderia_delicada[]" value="HELADERAS">
                <label class="form-check-label" for="delicada7">HELADERAS</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="delicada8" name="mercaderia_delicada[]" value="MAQUINARIA">
                <label class="form-check-label" for="delicada8">MAQUINARIA</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="delicada9" name="mercaderia_delicada[]" value="VEHÍCULOS">
                <label class="form-check-label" for="delicada9">VEHÍCULOS</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="delicada10" name="mercaderia_delicada[]" value="CERÁMICOS">
                <label class="form-check-label" for="delicada10">CERÁMICOS</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="delicada11" name="mercaderia_delicada[]" value="VASIJAS CERÁMICAS/VASIJAS BARRO">
                <label class="form-check-label" for="delicada11">VASIJAS CERÁMICAS/VASIJAS BARRO</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="delicada12" name="mercaderia_delicada[]" value="BULTOS DE PORCELANA">
                <label class="form-check-label" for="delicada12">BULTOS DE PORCELANA</label>
              </div>
            </div>
          </div>

          <!-- Instrucción para responder la siguiente pregunta -->
          <div class="mt-3">
            <p>Si seleccionó alguno de los ítems anteriores responder lo siguiente:</p>
          </div>

          <!-- Pregunta sobre el embalaje de la carga -->
          <div class="row mb-3">
            <div class="col-md-12">
              <label class="form-label">¿La carga se encuentra embalada en un cajón de madera cerrado, que cubre el 100% de la misma?</label>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="embalaje_si" name="embalaje_cajon" value="SI">
                <label class="form-check-label" for="embalaje_si">SI</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="embalaje_no" name="embalaje_cajon" value="NO">
                <label class="form-check-label" for="embalaje_no">NO</label>
              </div>
            </div>
          </div>

          <!-- Nota aclaratoria en caso de seleccionar NO -->
          <div class="mb-3">
            <small class="text-muted">
              (*) En caso de haber seleccionado “NO”, se hace saber que de acuerdo al Art. 1310 y ss del C.C. y C. N, corresponde al cargador de la mercadería asegurar el correcto y debido acondicionamiento de la carga que resultare de frágil y/o de fácil deterioro, siendo responsabilidad del transportista únicamente si se prueba su exclusiva culpa. A tales fines el transporte se reserva el derecho de rechazar la carga por motivos del embalaje y la naturaleza de la misma, quedando a exclusiva cuenta del cargador la responsabilidad según los alcances legales que pudieren corresponder según el caso particular.
            </small>
          </div>

          <!-- Datos del destinatario, igual que origen -->
          <hr>
          <h5><b>Datos del destinatario</b></h5>

            <div class="row">
            <div class="col-md-6 mb-3">
                <input type="text" id="destinatarioNombre" class="form-control" placeholder="Nombre o Razón Social" required>
            </div>
            <div class="col-md-6 mb-3">
                <input type="text" id="destinatarioCuit" class="form-control" placeholder="Cuit / Dni" required>
            </div>
            </div>

            <div class="row">
            <div class="col-md-6 mb-3">
                <input type="number" id="destinatarioTelefono" class="form-control" placeholder="Teléfono de Contacto" required>
            </div>
            <div class="col-md-6 mb-3">
                <input type="email" id="destinatarioMail" class="form-control" placeholder="Email" required>
            </div>
            </div>

            <div class="row">
            <div class="col-md-6 mb-3">
                <input type="text" id="destinatarioDomicilio" class="form-control" placeholder="Domicilio" required>
            </div>
            <div class="col-md-6 mb-3">
                <input type="text" id="destinatarioLocalidad" class="form-control" placeholder="Localidad" required>
            </div>
            </div>

            <div class="row">
            <div class="col-md-6 mb-3">
                <input type="text" id="destinatarioFranja" class="form-control" placeholder="Franja Horaria Entrega" required>
            </div>
            </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" id="guardarModal" class="btn btn-primary">Guardar</button>
        </div>
      </div>
    </div>
  </div>
