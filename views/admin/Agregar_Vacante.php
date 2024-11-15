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
                       <label for="disponibilidadVacante" class="form-label text-black">Disponibilidad:</label>
                       <select class="form-control form-select border-0 input-color w-100" id="disponibilidadVacante" required>
                           <option value="Disponible">Disponible</option>
                           <option value="No Disponible">No Disponible</option>
                       </select>
                   </div>

               </div>

               <!-- Descripción de la vacante -->
               <div class="row">
                   <div class="col-lg-12 mb-4">
                       <label for="descripcionVacante" class="form-label text-black">Descripción:</label>
                       <textarea class="form-control border-0 input-color" id="descripcionVacante" rows="7" placeholder="Ingrese la descripción de la vacante (Descripción, requisitos y qué ofrece)" required></textarea>
                   </div>
               </div>

               <!-- Botón de guardar vacante -->
               <div class="col-6 text-right">
                   <input type="submit" onclick="handleRegisterForm()" class="btn-reuse" value="Guardar vacante"></input>
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
                       <tr>
                           <td>Rompe colas</td>
                           <td>Romper colas dia y noche sin parar</td>
                           <td>Disponible</td>
                           <td>
                               <a href="#" class="btn btn-warning">Editar</a>
                               <a href="#" class="btn btn-danger">Eliminar</a>
                           </td>
                       </tr>
                       <tr>
                           <td>Rompe colas</td>
                           <td>Romper colas dia y noche sin parar</td>
                           <td>Disponible</td>
                           <td>
                               <a href="#" class="btn btn-warning">Editar</a>
                               <a href="#" class="btn btn-danger">Eliminar</a>
                           </td>
                       </tr>
                   </tbody>
               </table>
           </div>
       </div>
   </main>
   <script>
       // Function para manejar el registro de vacante usando jQuery/Ajax
       function handleRegisterForm() {
           event.preventDefault();

           const registrarVacante = document.getElementById("vacante-form");
           const nombreVacante = document.getElementById('nombreVacante').value;
           const descripcionVacante = document.getElementById('descripcionVacante').value;
           const disponibilidadVacante = document.getElementById('disponibilidadVacante').value;

           $.ajax({
               url: '/admin/Agregar_Vacante',
               method: 'POST',
               contentType: 'application/json',
               dataType: 'json',
               data: JSON.stringify({
                   nombreVacante: nombreVacante,
                   descripcionVacante: descripcionVacante,
                   disponibilidadVacante: disponibilidadVacante
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
   </script>