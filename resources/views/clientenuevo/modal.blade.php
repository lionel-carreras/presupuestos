<div class="modal fade modal-lg" id="clientenuevoModal" tabindex="-1" aria-labelledby="clientenuevoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form id="nuevoClienteForm" action="{{ route('cliente.nuevo.insert') }}" method="POST">
          @csrf
          <div class="modal-header">
            <img src="{{ asset('img/logo.png') }}" alt="Logo Expreso Brio" style="height: 100px;"><br>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body">
            <label class="form-label"><b>Datos del Cliente</b></label>
            <!-- Nombre o Razón Social -->
            <div class="mb-3">
              <input type="text" id="nuevoClienteNombre" name="nuevoClienteNombre" class="form-control" placeholder="Nombre o Razón Social" required>
            </div>
            <!-- Búsqueda de Localidad -->
            <div class="mb-3">
              <input type="text" id="nuevoClienteLocalidad" name="nuevoClienteLocalidad" placeholder="Localidad" class="form-control" required>
              <!-- Input hidden para guardar el código postal -->
              <input type="hidden" id="nuevoClienteLocalidadHidden" name="nuevoClienteLocalidadHidden">
              <!-- Contenedor para los resultados de búsqueda -->
              <div id="dropdownClienteLocalidad" class="dropdown-menu" style="display: none;"></div>
              <input type="hidden" id="sucursalEntregaFiscal" name="sucursalEntregaFiscal" value="">
            </div><br>
            <!-- Dirección-->
            <hr><label class="form-label"><b>Domicilio</b></label></hr>
            <div class="row mb-3">
              <div class="col-md-2">
                <label for="nuevoClienteTipoCalle" class="form-label">Tipo</label>
                <select id="nuevoClienteTipoCalle" name="nuevoClienteTipoCalle" class="form-select" required>
                  <option value="">Seleccione</option>
                  <option value="Calle">Calle</option>
                  <option value="Acceso">Acceso</option>
                  <option value="Autopista">Autopista</option>
                  <option value="Avenida">Avenida</option>
                  <option value="Boulevard">Boulevard</option>
                  <option value="Ruta Prov">Ruta Prov</option>
                  <option value="Ruta Nac">Ruta Nac</option>
                </select>
              </div>
              <div class="col-md-4">
                <label for="nuevoClienteCalle" class="form-label">Nombre</label>
                <input type="text" id="nuevoClienteCalle" name="nuevoClienteCalle" class="form-control" required>
              </div>
              <div class="col-md-2">
                <label for="nuevoClienteNumero" class="form-label">Número</label>
                <input type="number" id="nuevoClienteNumero" name="nuevoClienteNumero" class="form-control" placeholder="#" required>
              </div>
              <div class="col-md-2">
                <label for="nuevoClientePiso" class="form-label">Piso</label>
                <input type="text" id="nuevoClientePiso" name="nuevoClientePiso" class="form-control">
              </div>
              <div class="col-md-2">
                <label for="nuevoClienteDpto" class="form-label">Dpto</label>
                <input type="text" id="nuevoClienteDpto" name="nuevoClienteDpto" class="form-control">
              </div>
            </div>
            <br>
            <hr><label class="form-label"><b>Datos de facturación</b></label></hr>
            <div class="row mb-3">
                <div class="col-md-6">
                  <label for="nuevoClienteTipoIva" class="form-label">Tipo IVA</label>
                  <select id="nuevoClienteTipoIva" name="nuevoClienteTipoIva" class="form-select" required>
                    <option value="">Seleccione</option>
                    <option value="consFinal">Consumidor Final</option>
                    <option value="RI">Responsable Inscripto</option>
                    <option value="exento">Exento</option>
                  </select>
                </div>
                <div class="col-md-6">
                  <label for="nuevoClienteCuitDni" class="form-label">CUIT/DNI</label>
                  <input type="text" id="nuevoClienteCuitDni" name="nuevoClienteCuitDni" placeholder="CUIT/DNI" class="form-control" required>
                </div>
              </div>

            <!-- Teléfono -->
            <div class="mb-3">
              <input type="tel" id="nuevoClienteTelefono" name="nuevoClienteTelefono" placeholder="Teléfono" class="form-control" required>
            </div>
            <!-- Email -->
            <div class="mb-3">
              <input type="email" id="nuevoClienteMail" name="nuevoClienteMail" placeholder="Email" class="form-control" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>



  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



<script>
    // Función de búsqueda en tiempo real para localidades
    function configurarBusqueda(inputId, hiddenId, resultadosId, endpoint) {
  const input = document.getElementById(inputId);
  const hidden = document.getElementById(hiddenId);
  const resultados = document.getElementById(resultadosId);
  let activeIndex = -1;

  input.addEventListener('input', function(e) {
    const query = e.target.value.trim();
    activeIndex = -1;
    if (query.length >= 3) {
      fetch(`${endpoint}?query=${encodeURIComponent(query)}`)
        .then(response => {
          if (!response.ok) throw new Error('Error en la respuesta del servidor');
          return response.json();
        })
        .then(data => {
          resultados.innerHTML = '';
          resultados.style.display = 'block';
          if (data.length > 0) {
            data.forEach((localidad, index) => {
              const item = document.createElement('a');
              item.className = 'dropdown-item';
              item.href = '#';
              item.textContent = `${localidad.LocalidadNombre} (${localidad.CodigoPostal})`;
              item.dataset.codigoPostal = localidad.CodigoPostal;
              // Asumimos que la sucursal puede venir en mayúscula o minúscula:
              item.dataset.sucursalId = localidad.SucursalId || localidad.sucursalId;
              item.dataset.index = index;
              item.addEventListener('click', function(e) {
                e.preventDefault();
                input.value = `${localidad.LocalidadNombre} (${localidad.CodigoPostal})`;
                hidden.value = localidad.CodigoPostal;
                document.getElementById('sucursalEntregaFiscal').value =
                  localidad.SucursalId || localidad.sucursalId;
                resultados.style.display = 'none';
              });
              resultados.appendChild(item);
            });
          } else {
            resultados.innerHTML = '<div class="dropdown-item disabled">¡ No llegamos al destino !</div>';
          }
        })
        .catch(err => console.error(err));
    } else {
      resultados.style.display = 'none';
    }
  });

  input.addEventListener('keydown', function(e) {
    const items = resultados.querySelectorAll('.dropdown-item');
    if (resultados.style.display === 'block' && items.length > 0) {
      if (e.key === 'ArrowDown') {
        e.preventDefault();
        activeIndex = (activeIndex + 1) % items.length;
        actualizarSeleccion(items, activeIndex);
      } else if (e.key === 'ArrowUp') {
        e.preventDefault();
        activeIndex = (activeIndex - 1 + items.length) % items.length;
        actualizarSeleccion(items, activeIndex);
      } else if (e.key === 'Enter') {
        e.preventDefault();
        if (activeIndex >= 0) {
          const selectedItem = items[activeIndex];
          input.value = selectedItem.textContent;
          hidden.value = selectedItem.dataset.codigoPostal;
          document.getElementById('sucursalEntregaFiscal').value =
            selectedItem.dataset.sucursalId;
          resultados.style.display = 'none';
        }
      }
    }
  });

  document.addEventListener('click', function(e) {
    if (!resultados.contains(e.target) && e.target !== input) {
      resultados.style.display = 'none';
    }
  });

  function actualizarSeleccion(items, index) {
    items.forEach((item, i) => {
      item.classList.toggle('active', i === index);
    });
  }
}

configurarBusqueda('nuevoClienteLocalidad', 'nuevoClienteLocalidadHidden', 'dropdownClienteLocalidad', '/buscar-localidades');



    ///////////////////// Envío del formulario /////////////////////
  document.getElementById('nuevoClienteForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const form = this;
    const formData = new FormData(form);
    const token = document.querySelector('input[name="_token"]').value;

    fetch(form.action, {
      method: 'POST',
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': token
      },
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      if (data.ok) {
        Swal.fire({
          title: 'Cliente Creado',
          text: data.mensaje,
          icon: 'success',
          timer: 1500,
          showConfirmButton: false
        }).then(() => {
          // Actualizamos el formulario principal con los datos del nuevo cliente
          // Se asume que la respuesta contiene data.cliente con los campos necesarios
          document.getElementById('clientenombre').value = data.cliente.ClienteNombre;
          document.getElementById('clientecuit').value   = data.cliente.CUIT;
          document.getElementById('clientemail').value  = data.cliente.Email;
          // Opcional: si tienes un campo oculto para el ClienteID, lo asignas también
          document.getElementById('cliente_id').value   = data.cliente.ClienteID;

          // Cierra el modal y limpia el formulario del modal
          $('#clientenuevoModal').modal('hide');
          form.reset();
        });
      } else {
        console.error('Error:', data);
        Swal.fire({
          title: 'Error',
          text: data.mensaje || 'Ocurrió un error al crear el cliente.',
          icon: 'error',
          timer: 2000,
          showConfirmButton: false
        });
      }
    })
    .catch(err => {
      console.error(err);
      Swal.fire({
        title: 'Error',
        text: 'Ocurrió un error al enviar la solicitud.',
        icon: 'error',
        timer: 2000,
        showConfirmButton: false
      });
    });
  });


  </script>
