<div class="row mb-2">
    <div class="col-md-12">
        <div class="m-0 text-dark text-center text-lg">
            <h1><i class="fas fa-utensils"></i>&nbsp;&nbsp;Registro de Categorías</h1>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div style="max-width: 1140px; margin: 0 auto;">
            <form class="form-group register-form" action="/categorias/agregar" method="POST">
                <div class="mb-3 bg-form text-white p-5 rounded" style="margin-top: 20px;">
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger">
                            <?= htmlspecialchars($error); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($success)): ?>
                        <div id="success-message" class="alert alert-success">
                            <?= htmlspecialchars($success); ?>
                        </div>
                    <?php endif; ?>

                    <label class="fw-semibold" for="nombreCategoria">Nombre de Categoría:</label>
                    <input type="text" name="nombreCategoria" class="form-control input-formU nueva-clase" required>
                    <input type="submit" value="Agregar Categoría" class="btn btn-danger mt-3">
                </div>
            </form>

            <div class="table-wrapper table-responsive mt-4">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre de Categoría</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categorias as $categoria): ?>
                            <tr data-id="<?= $categoria['IdCategoría']; ?>">
                                <td><?= $categoria['IdCategoría']; ?></td>
                                <td class="nombre-categoria"><?= htmlspecialchars($categoria['NombreCategoría']); ?></td>
                                <td>
                                    <a href="#" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editarCategoriaModal" 
                                       onclick="abrirModalEditar(<?= $categoria['IdCategoría']; ?>, '<?= htmlspecialchars($categoria['NombreCategoría']); ?>')">
                                       Editar
                                    </a>
                                    <a href="#" class="btn btn-danger" onclick="eliminarCategoria(<?= $categoria['IdCategoría']; ?>)">Eliminar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editarCategoriaModal" tabindex="-1" aria-labelledby="editarCategoriaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form-editar-categoria" onsubmit="event.preventDefault(); editarCategoria();">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarCategoriaLabel">Editar Categoría</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="categoriaId" id="categoriaId">
                    <div class="mb-3">
                        <label for="nombreCategoriaEditar" class="form-label">Nombre de Categoría</label>
                        <input type="text" name="nombreCategoriaEditar" id="nombreCategoriaEditar" class="form-control" required>
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
    function eliminarCategoria(id) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "No podrás revertir esta acción",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',  
            cancelButtonColor: '#d33',  
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/admin/categorias/eliminar?id=${id}`, {
                    method: 'DELETE',
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: "Eliminado",
                            text: "La categoría ha sido eliminada exitosamente.",
                            icon: "success",
                            confirmButtonColor: '#3085d6'
                        }).then(() => {
                            location.reload(); 
                        });
                    } else {
                        Swal.fire({
                            title: "Oops...",
                            text: "Error al eliminar la categoría: " + data.error,
                            icon: "error"
                        });
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    Swal.fire({
                        title: "Oops...",
                        text: "Se produjo un error: " + error.message,
                        icon: "error"
                    });
                });
            }
        });
    }

    function abrirModalEditar(id, nombre) {
        document.getElementById('categoriaId').value = id;
        document.getElementById('nombreCategoriaEditar').value = nombre;
    }

    function editarCategoria() {
        const form = document.getElementById('form-editar-categoria');
        const formData = new FormData(form);

        fetch('/categorias/editar', {
            method: 'POST',
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    title: "Éxito",
                    text: "Categoría modificada exitosamente.",
                    icon: "success",
                    confirmButtonColor: '#3085d6'
                }).then(() => {
                    location.reload(); 
                });
            } else {
                Swal.fire({
                    title: "Oops...",
                    text: "Error al modificar la categoría: " + data.error,
                    icon: "error"
                });
            }
        })
        .catch(error => {
            console.error("Error:", error);
            Swal.fire({
                title: "Oops...",
                text: "Se produjo un error: " + error.message,
                icon: "error"
            });
        });
    }
</script>
