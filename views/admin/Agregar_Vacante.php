<div class="content-wrapper"> 
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-md-12">
                    <div class="m-0 text-dark text-center text-lg">
                        <h1><i class="fas fa-briefcase"></i>&nbsp;&nbsp;Registro de vacante</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-4 card-add-product">
        <div class="text-white">
            <form id="vacante-form">
                <h3 class="text-center text-black">Agregar vacante</h3>
                
                <!-- Nombre de la vacante -->
                <div class="row">
                    <div class="col-lg-10 mb-3"> 
                        <label for="nombreVacante" class="form-label text-black">Nombre de la vacante:</label>
                        <input type="text" class="form-control border-0 input-color" id="nombreVacante" required>
                    </div>
                </div>

                <!-- Descripción de la vacante -->
                <div class="row">
                    <div class="col-lg-12 mb-4">
                        <label for="descripcionVacante" class="form-label text-black">Descripción:</label>
                        <textarea class="form-control border-0 input-color" id="descripcionVacante" rows="4" placeholder="Ingrese la descripción de la vacante (Descripción, requisitos y qué ofrece)" required></textarea>
                    </div>
                </div>

                <!-- Disponibilidad -->
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="disponibilidadVacante" class="form-label text-black">Disponibilidad:</label>
                        <select class="form-control form-select border-0 input-color w-100" id="disponibilidadVacante" required>
                            <option value="Disponible">Disponible</option>
                            <option value="No Disponible">No Disponible</option>
                        </select>
                    </div>
                </div>

                <!-- Botón de guardar vacante -->
                <div class="col-6 text-right">
                    <input type="submit" onclick="handleRegisterForm()" class="btn btn-success">Guardar vacante</input>
                </div>
            </form>
        </div>
    </div>
</div>

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
        success: function (response) {
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
        error: function (xhr, status, error) {
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