<div class="container">
    <form class="form-group register-form" action="/categorias/agregar" method="POST">
        <div class="mb-3 bg-form  p-5 rounded">
            <h2 class="text-center text-black">Agregar Categoría</h2>
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

    <div class="table-wrapper table-responsive">
        <!-- Tabla de Categorías -->
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
                            <a href="#" class="btn btn-danger" onclick="eliminarCategoria(<?= $categoria['IdCategoría']; ?>)">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    </div>
</div>

<!-- Scripts -->
<script> 
// Script para manejar la eliminación
function eliminarCategoria(id) {
    if (confirm("¿Estás seguro de que deseas eliminar esta categoría?")) {
        fetch(`/admin/categorias/eliminar?id=${id}`, {
            method: 'DELETE',
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Categoría eliminada exitosamente.");
                location.reload(); // Recargar la página para ver los cambios
            } else {
                alert("Error al eliminar la categoría: " + data.error);
            }
        })
        .catch(error => {
            console.error("Error:", error);
        });
    }
}
</script>
