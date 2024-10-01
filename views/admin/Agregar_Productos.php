<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Productos</title>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/bootstrap.min_.css">
    <link rel="stylesheet" href="../css/Style-Admin.css">
    
</head>
<div class="container">
    <form action="/productos/agregar" method="POST" enctype="multipart/form-data">
        <div class="mb-3 bg-form text-white p-5 rounded" style="margin-top: 180px;">
            <h2 class="text-center">Agregar Productos</h2>
            <table border="1" style="margin-top: 20px; background-color: #F8F8F8; padding: 20px; width: 100%; max-width: 900px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); border-radius: 10px;">


                <tr>
                    <td><label for="nombrePlatillo" style="color: black;">Nombre del Producto:</label></td>
                    <td><input type="text" class="input-formU nueva-clase" id="nombrePlatillo" name="nombrePlatillo" required></td>
                    <td rowspan="5" style="text-align: center;">
                        <button for="imagenProducto" class="btn btn-success" id="subirImagenBtn">Subir Imagen:</label><br>
                        <input type="file" id="imagenProducto" name="imagenProducto" accept="image/*" class="btn btn-primary" required><br><br>

                        <div style="width: 300px; height: 200px; border: 1px solid #ccc; display: flex; justify-content: center; align-items: center;">
                            <img src="#" id="previewImagen" style="max-width: 100%; max-height: 100%; display: none;" alt="Vista previa">
                        </div>

                        <button type="button" id="eliminarImagen" style="margin-top: 10px; display: none;" class="btn btn-danger">Eliminar Imagen</button>
                    </td>
                </tr>

                <tr>
                    <td><label for="precioPlatillo" style="color: black;">Precio:</label></td>
                    <td><input type="number" step="0.01" class="input-formU nueva-clase" id="precioPlatillo" name="precioPlatillo" required></td>
                </tr>

                <tr>
                    <td><label for="descripcionPlatillo" style="color: black;">Descripción:</label></td>
                    <td><textarea class="input-formU nueva-clase" id="descripcionPlatillo" name="descripcionPlatillo" rows="3" required></textarea></td>
                </tr>

                <tr>
                    <td><label for="disponibilidad" style="color: black;">Disponibilidad:</label></td>
                    <td>
                        <select class="input-formU nueva-clase" id="disponibilidad" name="disponibilidad" required>
                            <option value="Disponible">Disponible</option>
                            <option value="No Disponible">No Disponible</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td><label for="categoria" style="color: black;">Categoría:</label></td>
                    <td>
                        <select class="input-formU nueva-clase" id="categoria" name="categoria" required>
                            <?php foreach ($categorias as $categoria) : ?>
                                <option value="<?= $categoria['IdCategoría'] ?>"><?= $categoria['NombreCategoría'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td colspan="3">
                        <input type="submit" value="Agregar Producto" class="btn btn-danger">
                    </td>
                </tr>
            </table>
    </form>

</div>
<!-- Scripts -->
<script>
    const subirImagenBtn = document.getElementById('subirImagenBtn');
    const imagenProducto = document.getElementById('imagenProducto');
    const previewImagen = document.getElementById('previewImagen');

    subirImagenBtn.addEventListener('click', () => {
        imagenProducto.click(); 
    });

    imagenProducto.addEventListener('change', (event) => {
        const file = event.target.files[0]; 
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                previewImagen.src = e.target.result; 
                previewImagen.style.display = 'block'; 
            };
            reader.readAsDataURL(file); 
        }
    });
</script>
<script>
    document.getElementById('imagenProducto').onchange = function(evt) {
        const [file] = this.files;
        if (file) {
            const preview = document.getElementById('previewImagen');
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
            document.getElementById('eliminarImagen').style.display = 'inline-block';
        }
    };

    document.getElementById('eliminarImagen').onclick = function() {
        const imagenInput = document.getElementById('imagenProducto');
        imagenInput.value = "";
        const preview = document.getElementById('previewImagen');
        preview.src = "";
        preview.style.display = 'none';
        this.style.display = 'none';
    };
</script>

<script src="../js/mainAdmin.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>