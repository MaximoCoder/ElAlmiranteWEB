   <!-- NAVBAR -->
   <nav>
       <i class='bx bx-menu'></i>
       <a href="#" class="nav-link">Categories</a>
       <form action="#">
           <div class="form-input">
               <input type="search" placeholder="Search...">
               <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
           </div>
       </form>
       <input type="checkbox" id="switch-mode" hidden>
       <label for="switch-mode" class="switch-mode"></label>

   </nav>
   <main>
       <div class="box-reusable">
           <form id="vacante-form">
               <h3 class="text-center text-black">Agregar vacante</h3>
               <!-- Nombre de la vacante -->
               <div class="row">
                   <div class="col-lg-8 mb-3">
                       <label for="nombreVacante" class="form-label text-black">Nombre de la vacante:</label>
                       <input type="text" class="form-control border-0 input-color" id="nombreVacante" required>
                   </div>
                   <!-- Disponibilidad -->

                   <div class="col-lg-4 mb-3">
                       <label for="Activa" class="form-label text-black">Disponibilidad:</label>
                       <select class="form-control form-select border-0 input-color w-100" id="Activa" required>
                           <option value="Disponible">Disponible</option>
                           <option value="No Disponible">No Disponible</option>
                       </select>
                   </div>

               </div>

               <!-- Descripción de la vacante -->
               <div class="row preformatted">
                   <div class="col-lg-12 mb-4">
                       <label for="descripcionVacante" class="form-label text-black">Descripción:</label>
                       <textarea class="form-control border-0 input-color" id="descripcionVacante" rows="7" placeholder="Ingrese la descripción de la vacante (Descripción, requisitos y qué ofrece)" required></textarea>
                   </div>
               </div>

               <!-- Botón de guardar vacante -->
               <div class="col-6 text-right">
                   <input type="submit" class="btn-reuse" value="Guardar vacante">
               </div>
           </form>
       </div>

       <div class="table-data">
           <div class="order">
               <div class="head">
                   <h3>Vacantes</h3>
                   <i class='bx bx-search'></i>
                   <i class='bx bx-filter'></i>
               </div>
               <table>
                   <thead>
                       <tr>
                           <th>Puesto</th>
                           <th>Descripcion</th>
                           <th>Disponibilidad</th>
                           <th>Acciones</th>
                       </tr>
                   </thead>
                   <tbody>
                       <?php if (!empty($vacantes)): ?>
                           <?php foreach ($vacantes as $vacante): ?>
                               <tr data-id="<?= htmlspecialchars($vacante['IdVacante']); ?>">
                                   <td><?= htmlspecialchars($vacante['nombreVacante']); ?></td>
                                   <td class="preformatted"><?= htmlspecialchars($vacante['descripcionVacante']); ?></td>
                                   <td><?= htmlspecialchars($vacante['Activa']); ?></td>
                                   <td>
                                       <a href="#" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editarVacanteModal"><i class='bx bxs-edit'></i></a>
                                       <a href="#" class="btn btn-danger" onclick="eliminarVacante(<?= htmlspecialchars($vacante['IdVacante']); ?>)"><i class='bx bxs-trash'></i></a>
                                   </td>
                               </tr>
                           <?php endforeach; ?>
                       <?php else: ?>
                           <tr>
                               <td colspan="4">No hay vacantes registradas</td>
                           </tr>
                       <?php endif; ?>
                   </tbody>
               </table>
           </div>
       </div>
   </main>

   <div class="modal fade" id="editarVacanteModal" tabindex="-1" aria-labelledby="editarVacanteModalLabel" aria-hidden="true">
       <div class="modal-dialog">
           <div class="modal-content">
               <form id="form-editar-vacante" onsubmit="editarVacante(event)">
                   <div class="modal-header">
                       <h5 class="modal-title" id="editarVacanteModalLabel">Editar Vacante</h5>
                       <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                   </div>
                   <div class="modal-body">
                       <input type="hidden" name="vacanteId" id="vacanteId">
                       <div class="mb-3">
                           <label for="nombreVacanteEditar" class="form-label">Nombre de la vacante</label>
                           <input type="text" name="nombreVacanteEditar" id="nombreVacanteEditar" class="form-control" required>

                           <label for="descripcionVacanteEditar" class="form-label mt-3">Descripción de la vacante</label>
                           <textarea name="descripcionVacanteEditar" id="descripcionVacanteEditar" class="form-control" required></textarea>

                           <label for="disponibilidadVacanteEditar" class="form-label mt-3">Disponibilidad</label>
                           <select name="disponibilidadVacanteEditar" id="disponibilidadVacanteEditar" class="form-control" required>
                               <option value="Disponible">Disponible</option>
                               <option value="No Disponible">No Disponible</option>
                           </select>
                       </div>
                   </div>
                   <div class="modal-footer">
                       <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                       <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                   </div>
               </form>
           </div>
       </div>
   </div>

   <script>
       // Function para manejar el registro de vacante usando jQuery/Ajax
       function handleRegisterForm(event) {
           event.preventDefault();

           const registrarVacante = document.getElementById("vacante-form");
           const nombreVacante = document.getElementById('nombreVacante').value;
           const descripcionVacante = document.getElementById('descripcionVacante').value;
           const Activa = document.getElementById('Activa').value;

           $.ajax({
               url: '/admin/Agregar_Vacante',
               method: 'POST',
               contentType: 'application/json',
               dataType: 'json',
               data: JSON.stringify({
                   nombreVacante: nombreVacante,
                   descripcionVacante: descripcionVacante,
                   Activa: Activa
               }),
               success: function(response) {
                   if (response.status === 'success') {
                       registrarVacante.reset();
                       Swal.fire({
                           title: "Listo!",
                           text: response.message || "Vacante registrada exitosamente.",
                           icon: "success",
                           showConfirmButton: false,
                           timer: 1500
                       }).then(() => {
                           location.reload();
                       });
                   } else {
                       // Muestra el mensaje de error que proviene del servidor
                       Swal.fire({
                           title: "Oops...",
                           text: response.message || "Hubo un problema al registrar.",
                           icon: "error"
                       });
                   }
               },
               error: function(xhr, status, error) {
                   console.log("Respuesta completa del servidor: ", xhr.responseText); // Mostrar la respuesta en la consola
                   Swal.fire({
                       title: "Oops...",
                       text: "Error en la solicitud: " + error,
                       icon: "error"
                   });
               }
           });
       }

       function eliminarVacante(idVacante) {
           Swal.fire({
               title: '¿Estás seguro?',
               text: "No podrás revertir esta acción",
               icon: 'warning',
               showCancelButton: true,
               confirmButtonColor: '#3085d6',
               cancelButtonColor: '#d33',
               confirmButtonText: 'Si, eliminar',
               cancelButtonText: 'Cancelar'
           }).then((result) => {
               if (result.isConfirmed) {
                   fetch(`/admin/Agregar_Vacante/eliminar`, {
                           method: 'DELETE',
                           headers: {
                               'Content-Type': 'application/json'
                           },
                           body: JSON.stringify({
                               idVacante: idVacante
                           })
                       })
                       .then(response => {
                           if (!response.ok) {
                               throw new Error('Error en la respuesta del servidor');
                           }
                           return response.json();
                       })
                       .then(data => {
                           if (data.status === 'success') {
                               Swal.fire({
                                   title: "Eliminado",
                                   text: data.message,
                                   icon: "success",
                                   showConfirmButton: 'false'
                               }).then(() => {
                                   location.reload();
                               });
                           } else {
                               throw new Error(data.message || 'Error al eliminar la vacante');
                           }
                       })
                       .catch(error => {
                           console.error("Error:", error);
                           Swal.fire({
                               title: "Error",
                               text: error.message,
                               icon: "error"
                           });
                       });
               }
           });
       }

       function abrirModalEditarVacante(id, nombre, descripcion, estado) {
           document.getElementById('vacanteId').value = id;
           document.getElementById('nombreVacanteEditar').value = nombre;
           document.getElementById('descripcionVacanteEditar').value = descripcion;
           document.getElementById('disponibilidadVacanteEditar').value = estado;
       }

       function editarVacante(event) {
           const idVacante = document.getElementById('vacanteId').value;
           const nombreVacante = document.getElementById('nombreVacanteEditar').value;
           const descripcionVacante = document.getElementById('descripcionVacanteEditar').value;
           const estadoVacante = document.getElementById('disponibilidadVacanteEditar').value;

           const data = {
               idVacante: idVacante,
               nombreVacante: nombreVacante,
               descripcionVacante: descripcionVacante,
               Activa: estadoVacante
           };

           $.ajax({
               url: '/admin/Agregar_Vacante/editar',
               method: 'PUT',
               contentType: 'application/json',
               dataType: 'json',
               data: JSON.stringify(data),
               success: function(response) {
                   if (response.status === 'success') {
                       //Actualizar la tabla sin recargar la página
                       const row = document.querySelector(`tr[data-id="${idVacante}"]`);
                       if (row) {
                           row.querySelector('td:nth-child(1)').textContent = nombreVacante;
                           row.querySelector('td:nth-child(2)').textContent = descripcionVacante;
                           row.querySelector('td:nth-child(3)').textContent = estadoVacante;
                       }
                       $('#editarVacanteModal').modal('hide');
                       Swal.fire({
                           title: "Listo!",
                           text: response.message || "Vacante editada exitosamente.",
                           icon: "success",
                           showConfirmButton: false,
                           timer: 1500
                       })
                   } else {
                       // Muestra el mensaje de error que proviene del servidor
                       Swal.fire({
                           title: "Oops...",
                           text: response.message || "Hubo un problema al editar.",
                           icon: "error"
                       });
                   }
               },
               error: function(xhr, status, error) {
                   console.log("Respuesta completa del servidor: ", xhr.responseText); // Mostrar la respuesta en la consola
                   Swal.fire({
                       title: "Oops...",
                       text: "Error en la solicitud: " + error,
                       icon: "error"
                   });
               }
           });
       }

       document.addEventListener("DOMContentLoaded", function() {
           document.getElementById("vacante-form").addEventListener("submit", handleRegisterForm);
           document.getElementById("form-editar-vacante").addEventListener("submit", editarVacante);

           document.querySelectorAll('.btn-warning').forEach(btn => {
        btn.addEventListener('click', function() {
            const tr = this.closest('tr');
            const id = tr.dataset.id;
            const nombre = tr.querySelector('td:nth-child(1)').textContent;
            const descripcion = tr.querySelector('td:nth-child(2)').textContent;
            const estado = tr.querySelector('td:nth-child(3)').textContent;
            abrirModalEditarVacante(id, nombre, descripcion, estado);
        });
    });
       });
   </script>