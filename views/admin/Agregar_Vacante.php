<div class="container">
    <form class="form-group register-form" id="registrarVacante">
        <div class="mb-3 bg-form text-white p-5 rounded">
            <h2 class="text-center">Registrar Vacante</h2>
            <label for="" class="mt-4 fw-semibold">Nombre de la vacante:</label>
            <input type="text" id="nombreVacante" class="form-control input-formU" value="<?php echo isset($_POST["nombreVacante"]) ? $_POST["nombreVacante"] : ''; ?>" required>
        
            <label class="fw-semibold" for="descripcionVacante">Descripción de la vacante:</label>
            <textarea id="descripcionVacante" class="form-control input-formU" required><?php echo isset($_POST["descripcionVacante"]) ? $_POST["descripcionVacante"] : ''; ?></textarea>
            
            <label for="disponibilidad" class="form-label text-black">Disponibilidad:</label>
                <select class="form-control form-select border-0  input-color" name="Disponibilidad" required>
                    <option value="Disponible">Disponible</option>
                    <option value="No Disponible">No Disponible</option>
                </select>

            <input type="submit" class="form-control btn-color fw-bold" onclick="registrarVacante()" >
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