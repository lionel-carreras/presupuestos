
<script>




///////////////// retiro SI O NO /////////////////
    function toggleSwitchLabel(checkbox) {
  const label = document.getElementById('switchLabel');
  if (checkbox.checked) {
    // Cuando el switch está activo
    label.textContent = 'SI';
    label.style.color = 'background-color: #00c479';
  } else {
    // Cuando el switch está inactivo
    label.textContent = 'NO';
   label.style.color = 'red';
  }
}
// Bandera para controlar si ya se guardaron los datos del modal
window.modalDataSaved = false;

// Modificar el submit del formulario
document.querySelector('#formPresupuesto').addEventListener('submit', function (e) {
  // Si NO se marca "retiro a domicilio", copiar el valor de "descripcion_sinretiro" al input oculto "mercaderia_descripcion_hidden"
  if (!document.querySelector('#retirarDomicilio').checked) {
    document.getElementById('mercaderia_descripcion_hidden').value =
      document.getElementById('descripcion_sinretiro').value;
  }

  // Si se marca "retiro a domicilio" y aún no se han guardado los datos del modal, mostrar el modal
  if (document.querySelector('#retirarDomicilio').checked && !window.modalDataSaved) {
    e.preventDefault();
    // Copiar datos del formulario principal al modal (como ya lo haces)
    document.getElementById('nombreRemitente').value = document.getElementById('clientenombre').value;
    document.getElementById('docRemitente').value = document.getElementById('clientecuit').value;
    document.getElementById('mailRemitente').value = document.getElementById('clientemail').value;
    document.getElementById('cantidadModal').value = document.getElementById('cantidad').value;
    document.getElementById('altoModal').value = document.getElementById('alto').value;
    document.getElementById('anchoModal').value = document.getElementById('ancho').value;
    document.getElementById('largoModal').value = document.getElementById('largo').value;
    document.getElementById('pesoModal').value = document.getElementById('kilos').value;
    document.getElementById('valorDeclaradoModal').value = document.getElementById('valor').value;

    let cpOrigenValue = document.getElementById('cporigen').value;
    let localidadName = cpOrigenValue.split(' (')[0];
    document.getElementById('localidadRetiro').value = localidadName;

    // Copiar datos del destinatario al modal
    document.getElementById('destinatarioNombre_hidden').value = document.getElementById('destinatarioNombre').value;
    document.getElementById('destinatarioCuit_hidden').value = document.getElementById('destinatarioCuit').value;
    document.getElementById('destinatarioTelefono_hidden').value = document.getElementById('destinatarioTelefono').value;
    document.getElementById('destinatarioMail_hidden').value = document.getElementById('destinatarioMail').value;
    document.getElementById('destinatarioDomicilio_hidden').value = document.getElementById('destinatarioDomicilio').value;
    document.getElementById('destinatarioLocalidad_hidden').value = document.getElementById('destinatarioLocalidad').value;
    document.getElementById('destinatarioFranja_hidden').value = document.getElementById('destinatarioFranja').value;

    // Copiar el valor del input "descripcion_sinretiro" al textarea del modal "descripcionModal"
    document.getElementById('descripcionModal').value =
      document.getElementById('descripcion_sinretiro').value;

    let modalInstance = new bootstrap.Modal(document.getElementById('retiroModal'));
    modalInstance.show();
    return;
  }

  e.preventDefault();
  // Aquí continúa el envío del formulario vía fetch
  const clienteId = document.querySelector('#cliente_id').value.trim();
  if (!clienteId) {
    Swal.fire({
      icon: 'info',
      title: 'Cliente no encontrado',
      text: 'El cliente no existe en la base, comuníquese con atencionalcliente@brio.com.ar o al 0810-888-2746.'
    }).then((result) => {
      if (result.isConfirmed) {
        document.querySelector('#formPresupuesto').reset();
      }
    });
    return;
  }
  const formData = new FormData(this);
  fetch('{{ route("calcular.presupuesto") }}', {
    method: 'POST',
    body: formData,
    headers: { 'X-Requested-With': 'XMLHttpRequest' },
  })
  .then((response) => {
    if (!response.ok) throw new Error('Error en la respuesta del servidor');
    return response.json();
  })
  .then((data) => {
    if (data.error) {
      Swal.fire({
        icon: 'info',
        title: 'Tarifa acordada',
        text: data.mensaje,
      });
      return;
    }
    Swal.fire({
      icon: 'success',
      title: 'Presupuesto Calculado',
      text: 'Recibirás un correo con toda la Info!!'
    }).then((result) => {
      if (result.isConfirmed) {
        document.querySelector('#formPresupuesto').reset();
      }
    });
    document.querySelector('#sucursal_id_origen').value = data.sucursal_id_origen || '';
    document.querySelector('#sucursal_id_destino').value = data.sucursal_id_destino || '';
    document.querySelector('#tarifa_id').value = data.tarifa_id || '';
    const token = document.querySelector('input[name="_token"]').value;
    // Construir el payload sobrescribiendo "descripcion" con el valor deseado:
    const payload = {
  ...data,
  _token: token,
  sucursal_id_origen: document.querySelector('#sucursal_id_origen').value,
  sucursal_id_destino: document.querySelector('#sucursal_id_destino').value,
  tarifa_id: document.querySelector('#tarifa_id').value,
  retirar_domicilio: document.querySelector('#retirarDomicilio').checked ? '1' : '0',
  pago_en_hidden: document.getElementById('pago_en_hidden').value,
  remitente_nombre_hidden: document.getElementById('remitente_nombre_hidden').value,
  remitente_telefono_hidden: document.getElementById('remitente_telefono_hidden').value,
  remitente_mail_hidden: document.getElementById('remitente_mail_hidden').value,
  remitente_doc_hidden: document.getElementById('remitente_doc_hidden').value,
  retiro_domicilio_hidden: document.getElementById('retiro_domicilio_hidden').value,
  retiro_localidad_hidden: document.getElementById('retiro_localidad_hidden').value,
  retiro_franja_hidden: document.getElementById('retiro_franja_hidden').value,
  mercaderia_largo_hidden: document.getElementById('mercaderia_largo_hidden').value || document.getElementById('largo').value,
  mercaderia_alto_hidden: document.getElementById('mercaderia_alto_hidden').value || document.getElementById('alto').value,
  mercaderia_ancho_hidden: document.getElementById('mercaderia_ancho_hidden').value || document.getElementById('ancho').value,
  mercaderia_peso_hidden: document.getElementById('mercaderia_peso_hidden').value || document.getElementById('kilos').value,
  mercaderia_cantidad_hidden: document.getElementById('mercaderia_cantidad_hidden').value || document.getElementById('cantidad').value,
  mercaderia_descripcion_hidden: document.getElementById('mercaderia_descripcion_hidden').value || document.getElementById('descripcion_sinretiro').value,
  mercaderia_delicada: document.getElementById('mercaderia_delicada_hidden').value,
  mercaderia_valor_declarado_hidden: document.getElementById('mercaderia_valor_declarado_hidden').value || document.getElementById('valor').value,
  embalaje_hidden: document.getElementById('embalaje_hidden').value,
  embalaje_cajon: document.getElementById('embalaje_cajon_hidden').value,
  destinatario_nombre: document.getElementById('destinatarioNombre_hidden').value,
  destinatario_doc: document.getElementById('destinatarioCuit_hidden').value,
  destinatario_telefono: document.getElementById('destinatarioTelefono_hidden').value,
  destinatario_mail: document.getElementById('destinatarioMail_hidden').value,
  destinatario_domicilio: document.getElementById('destinatarioDomicilio_hidden').value,
  destinatario_localidad: document.getElementById('destinatarioLocalidad_hidden').value,
  destinatario_franja: document.getElementById('destinatarioFranja_hidden').value,
};




    fetch('{{ route("enviar.correo.presupuesto") }}', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
      },
      body: JSON.stringify(payload)
    })
    .then(resp => resp.json())
    .then(respData => {
      if (respData.ok) {
        console.log('Correo enviado e inserción realizada.');
      } else {
        console.warn('Error al enviar correo:', respData);
      }
    })
    .catch((error) => {
      console.error('Error al enviar correo:', error);
    });
  })
  .catch((error) => {
    console.error('Error:', error);
    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: 'Ocurrió un error al calcular el presupuesto. Intente nuevamente.'
    });
  });
});


// Al hacer clic en "Guardar" del modal, copiar los valores a los inputs ocultos y re-disparar el submit
document.querySelector('#guardarModal').addEventListener('click', function () {
  // Copiar datos de texto
  document.getElementById('pago_en_hidden').value = document.getElementById('pagoEn').value;
  document.getElementById('remitente_nombre_hidden').value = document.getElementById('nombreRemitente').value;
  document.getElementById('remitente_telefono_hidden').value = document.getElementById('telefonoRemitente').value;
  document.getElementById('remitente_mail_hidden').value = document.getElementById('mailRemitente').value;
  document.getElementById('remitente_doc_hidden').value = document.getElementById('docRemitente').value;
  document.getElementById('retiro_domicilio_hidden').value = document.getElementById('domicilioRetiro').value;
  document.getElementById('retiro_localidad_hidden').value = document.getElementById('localidadRetiro').value;
  document.getElementById('retiro_franja_hidden').value = document.getElementById('franjaHorariaRetiro').value;
  document.getElementById('mercaderia_largo_hidden').value = document.getElementById('largoModal').value;
  document.getElementById('mercaderia_alto_hidden').value = document.getElementById('altoModal').value;
  document.getElementById('mercaderia_ancho_hidden').value = document.getElementById('anchoModal').value;
  document.getElementById('mercaderia_peso_hidden').value = document.getElementById('pesoModal').value;
  document.getElementById('mercaderia_cantidad_hidden').value = document.getElementById('cantidadModal').value;
  document.getElementById('mercaderia_descripcion_hidden').value = document.getElementById('descripcionModal').value;
  document.getElementById('mercaderia_valor_declarado_hidden').value = document.getElementById('valorDeclaradoModal').value;

  // Copiar los checkbox de mercadería delicada: unir los valores seleccionados separados por comas
  let mercaderiaDelicada = [];
    document.querySelectorAll('input[name="mercaderia_delicada[]"]:checked').forEach(function(el) {
    mercaderiaDelicada.push(el.value);
    });
    document.getElementById('mercaderia_delicada_hidden').value = mercaderiaDelicada.join(',');

  // Copiar los checkbox de embalaje (tipo de mercadería)
  let embalaje = [];
  if (document.getElementById('caja').checked) embalaje.push('caja');
  if (document.getElementById('pallet').checked) embalaje.push('pallet');
  if (document.getElementById('irregular').checked) embalaje.push('irregular');
  document.getElementById('embalaje_hidden').value = embalaje.join(',');
  //1console.log("Valor asignado a embalaje_hidden:", document.getElementById('embalaje_hidden').value);

  // Copiar la respuesta de la pregunta del cajón de madera
  let embalajeCajon = "";
  if (document.getElementById('embalaje_si').checked) {
    embalajeCajon = "SI";
  } else if (document.getElementById('embalaje_no').checked) {
    embalajeCajon = "NO";
  }
  document.getElementById('embalaje_cajon_hidden').value = embalajeCajon;
  //console.log("Valor asignado a embalaje_cajon_hidden:", document.getElementById('embalaje_cajon_hidden').value);

  // Copiar datos del destinatario
  document.getElementById('destinatarioNombre_hidden').value = document.getElementById('destinatarioNombre').value;
  document.getElementById('destinatarioCuit_hidden').value = document.getElementById('destinatarioCuit').value;
  document.getElementById('destinatarioTelefono_hidden').value = document.getElementById('destinatarioTelefono').value;
  document.getElementById('destinatarioMail_hidden').value = document.getElementById('destinatarioMail').value;
  document.getElementById('destinatarioDomicilio_hidden').value = document.getElementById('destinatarioDomicilio').value;
  document.getElementById('destinatarioLocalidad_hidden').value = document.getElementById('destinatarioLocalidad').value;
  document.getElementById('destinatarioFranja_hidden').value = document.getElementById('destinatarioFranja').value;

  // Marcar que los datos del modal ya se han guardado
  window.modalDataSaved = true;
  let modalInstance = bootstrap.Modal.getInstance(document.getElementById('retiroModal'));
  modalInstance.hide();
  // Re-disparar el submit para continuar con el flujo
  document.querySelector('#formPresupuesto').dispatchEvent(new Event('submit', {cancelable: true}));
});


// (El resto de tus scripts de búsqueda permanece sin cambios)
// ---------------- BÚSQUEDA DE LOCALIDADES ----------------
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
              item.dataset.index = index;
              item.addEventListener('click', function(e) {
                e.preventDefault();
                input.value = `${localidad.LocalidadNombre} (${localidad.CodigoPostal})`;
                hidden.value = localidad.CodigoPostal;
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
configurarBusqueda('cporigen', 'codigo_postal_origen', 'resultados', '/buscar-localidades');
configurarBusqueda('cpdestino', 'codigo_postal_destino', 'resultados2', '/buscar-localidades');
// ---------------- BÚSQUEDA DE CLIENTES (CUIT) ----------------
function configurarBusquedaClientes() {
  const inputCuit = document.getElementById('clientecuit');
  const inputNombre = document.getElementById('clientenombre');
  const dropdown = document.getElementById('dropdownClientes');
  const hiddenClienteId = document.getElementById('cliente_id');
  let activeIndex = -1;

  inputCuit.addEventListener('input', function(e) {
    const query = e.target.value.trim();
    activeIndex = -1;
    if (query.length >= 3) {
      fetch('/buscar-clientes?query=' + encodeURIComponent(query))
        .then(response => {
          if (!response.ok) throw new Error('Error en la respuesta del servidor');
          return response.json();
        })
        .then(data => {
          dropdown.innerHTML = '';
          dropdown.style.display = 'block';
          if (data.length > 0) {
            data.forEach((cliente, index) => {
              const item = document.createElement('a');
              item.className = 'dropdown-item';
              item.href = '#';

              let cuitVal = cliente.CUIT;
              if (cuitVal === "__-________-_") {
                cuitVal = "";
              }
              const docNumber = cuitVal || cliente.DNI || "Sin Documento";
              item.textContent = `${docNumber} - ${cliente.ClienteNombre}`;

              // Guardamos en data-* los valores
              item.dataset.cuit = cliente.CUIT;
              item.dataset.dni  = cliente.DNI;
              item.dataset.nombre = cliente.ClienteNombre;
              item.dataset.clienteId = cliente.ClienteID;
              item.dataset.index = index;

              // Listener de clic EN ESTE BLOQUE:
              item.addEventListener('click', function(e) {
                e.preventDefault();
                let cuitVal = this.dataset.cuit;
                if (cuitVal === "__-________-_") {
                  cuitVal = this.dataset.dni || "";
                }
                inputCuit.value = cuitVal;
                inputNombre.value = this.dataset.nombre;
                hiddenClienteId.value = this.dataset.clienteId;
                dropdown.style.display = 'none';
              });

              dropdown.appendChild(item);
            });
        } else {
            dropdown.innerHTML = '<a class="dropdown-item nuevo-cliente-link" href="#">¿ Cliente Nuevo? CLICK AQUÍ !!</a>';
        }


        })
        .catch(error => console.error(error));
    } else {
      dropdown.style.display = 'none';
    }
  });
///////////  MODAL CLIENTE NUEVO //////////////
  document.addEventListener('click', function(e) {
  if(e.target.matches('.nuevo-cliente-link')) {
    e.preventDefault();
    let modalEl = document.getElementById('clientenuevoModal');
    if(modalEl) {
      let modalInstance = bootstrap.Modal.getOrCreateInstance(modalEl);
      modalInstance.show();
    } else {
      console.error('No se encontró el modal con id "clientenuevoModal".');
    }
  }
});
document.addEventListener('keydown', function(e) {
  if (e.key === "Enter" && e.target.matches('.nuevo-cliente-link')) {
    e.preventDefault();
    e.target.click();
  }
});




  // Manejo con flechas y Enter
  inputCuit.addEventListener('keydown', function(e) {
  const items = dropdown.querySelectorAll('.dropdown-item');
  if (dropdown.style.display === 'block' && items.length > 0) {
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
        // Si el elemento activo es el enlace para "Cliente Nuevo", disparar su click
        if (selectedItem.classList.contains('nuevo-cliente-link')) {
          selectedItem.click();
        } else {
          let cuitVal = selectedItem.dataset.cuit;
          if (cuitVal === "__-________-_") {
            cuitVal = selectedItem.dataset.dni || "";
          }
          inputCuit.value = cuitVal;
          inputNombre.value = selectedItem.dataset.nombre;
          hiddenClienteId.value = selectedItem.dataset.clienteId;
          dropdown.style.display = 'none';
        }
      }
    }
  }
});


  // Cerrar dropdown si se hace clic fuera
  document.addEventListener('click', function(e) {
    if (!dropdown.contains(e.target) && e.target !== inputCuit) {
      dropdown.style.display = 'none';
    }
  });

  // Resalta la selección en el dropdown
  function actualizarSeleccion(items, index) {
    items.forEach((item, i) => {
      item.classList.toggle('active', i === index);
    });
  }
}

document.addEventListener('DOMContentLoaded', configurarBusquedaClientes);

</script>
