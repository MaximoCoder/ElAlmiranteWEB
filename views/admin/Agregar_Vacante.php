<div class="container mt-5">
    <h2 class="mb-4">Registrar vacante</h2>
    <form id="registrarVacante">
        <!-- Nombre de la vacante -->
        <div class="row mb-3">
            <div class="col-12">
                <label for="nombreVacante" class="form-label">Nombre de la vacante:</label>
                <input type="text" class="form-control" id="nombreVacante" placeholder="Ingrese el nombre de la vacante:" required>
            </div>
        </div>
        
        <!-- Descripción de la vacante -->
        <div class="row mb-3">
            <div class="col-12">
                <label for="descripcionVacante" class="form-label">Descripción</label>
                <textarea class="form-control" id="descripcionVacante" rows="10" placeholder="Ingrese la descripción de la vacante: (Descripción, requisitos y qué ofrece)" required></textarea>
            </div>
        </div>
        
        <!-- Disponibilidad -->
        <div class="row mb-3">
            <div class="col-12">
                <label for="disponibilidadVacante" class="form-label">Disponibilidad</label>
                <select class="form-select" id="disponibilidadVacante" required>
                    <option selected disabled>Seleccione la disponibilidad</option>
                    <option value="Disponible">Disponible</option>
                    <option value="No Disponible">No Disponible</option>
                </select>
            </div>
        </div>
        
        <!-- Botón de submit -->
        <div class="row">
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Agregar vacante</button>
            </div>
        </div>
    </form>
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