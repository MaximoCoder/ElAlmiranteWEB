<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Categorías</title>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/bootstrap.min_.css">
    <link rel="stylesheet" href="../css/Style-Admin.css">
</head>
<body>
<div class="container">
    <form class="form-group register-form" action="/categorias/agregar" method="POST">
        <div class="mb-3 bg-form text-white p-5 rounded" style="margin-top: 50px;">
            <h2 class="text-center">Agregar Categoría</h2>
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
<script src="../js/mainAdmin.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>

</body>
</html>
