<div class="container mt-5">
    <h2 class="mb-4">Registro de Nueva Vacante</h2>

    <!-- Contenedor del formulario, haciendo uso de la rejilla de Bootstrap para ser responsivo -->
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <form id="vacanteForm">
                <!-- Campo para el nombre de la vacante -->
                <div class="mb-3">
                    <label for="nombreVacante" class="form-label">Nombre de la Vacante</label>
                    <input type="text" class="form-control" id="nombreVacante" required>
                </div>

                <!-- Campo para la descripción del puesto -->
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción del Puesto</label>
                    <textarea class="form-control" id="descripcion" rows="3" required></textarea>
                </div>

                <!-- Botón para enviar el formulario -->
                <button type="submit" class="btn btn-primary w-100">
                    <i class="lni lni-pencil-alt"></i> Crear Vacante
                </button>
            </form>
        </div>
    </div>
</div>