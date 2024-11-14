<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-md-12 text-center">
                    <h1><i class="fas fa-briefcase"></i>&nbsp;&nbsp;Registro de vacantes</h1>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container mt-4 card-add-product">
        <div class="card p-4">
            <form id="registrarVacante">
                <h3 class="text-center">Agregar vacante</h3>
                
                <div class="row mb-3">
                    <div class="col-lg-8">
                        <label for="nombreVacante" class="form-label">Nombre de la vacante:</label>
                        <input type="text" class="form-control border-0 input-color" id="nombreVacante" placeholder="Ingrese el nombre de la vacante" required>
                    </div>
                    <div class="col-lg-4">
                        <label for="disponibilidadVacante" class="form-label">Disponibilidad:</label>
                        <select class="form-control border-0 input-color" id="disponibilidadVacante" required>
                            <option value="" disabled selected>Seleccione la disponibilidad</option>
                            <option value="Disponible">Disponible</option>
                            <option value="No Disponible">No Disponible</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-lg-12">
                        <label for="descripcionVacante" class="form-label">Descripción:</label>
                        <textarea class="form-control border-0 input-color" id="descripcionVacante" rows="7" placeholder="Ingrese la descripción de la vacante: (Descripción, requisitos y qué ofrece)" required></textarea>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary w-100">Guardar vacante</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
//Añade evento submit al formulario y previene que se envie recargando la página    
    document.getElementById("registrarVacante").addEventListener("submit", function(event) {
        event.preventDefault();
        handleRegisterForm();
    });

// Function para manejar el registro de vacante usando jQuery/Ajax
function handleRegisterForm() {
    const registrarVacante = document.getElementById("registrarVacante");
    const nombreVacante = document.getElementById('nombreVacante').value;
    const descripcionVacante = document.getElementById('descripcionVacante').value;

    $.ajax({
        url: '/admin/Agregar_Vacante',
        method: 'POST',
        contentType: 'application/json',
        dataType: 'json',
        data: JSON.stringify({
            nombreVacante: nombreVacante,
            descripcionVacante: descripcionVacante
        }),
        success: function (response) {
            if (response.status === 'success') {
                registrarVacante.reset();
            } else {
                // Muestra el mensaje de error que proviene del servidor
                Swal.fire({
                    title: "Oops...",
                    text: response.message || "Hubo un problema al registrar.",
                    icon: "error"
                });
            }
        },
        error: function (xhr, status, error) {
            //console.log("Respuesta completa del servidor: ", xhr.responseText); // Mostrar la respuesta en la consola
            Swal.fire({
                title: "Oops...",
                text: "Error en la solicitud: " + error,
                icon: "error"
            });
        }
    });
});
}
</script>