<div class="container mt-4 card-add-product  ">
    <div class="text-white  ">
        <form  id="platillo-form">
            <h3 class="text-center text-black">Agregar Platillo</h3>
            <div class="row">
                <div class="col-lg-8 mb-3">
                    <label for="nombrePlatillo" class="form-label text-black">Nombre del Producto:</label>
                    <input type="text" class="form-control nueva-clase"  name="NombrePlatillo" required>
                </div>
                <div class="col-lg-4 mb-3">
                    <label for="precioPlatillo" class="form-label text-black">Precio:</label>
                    <input type="number" step="1" class="form-control nueva-clase" name="PrecioPlatillo" required>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 mb-4">
                    <label for="descripcionPlatillo" class="form-label text-black">Descripción:</label>
                    <textarea class="form-control nueva-clase" name="DescripcionPlatillo"  rows="3" required></textarea>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="disponibilidad" class="form-label text-black">Disponibilidad:</label>
                    <select class="form-control form-select nueva-clase" name="Disponibilidad"  required>
                        <option value="Disponible">Disponible</option>
                        <option value="No Disponible">No Disponible</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="categoria" class="form-label text-black">Categoría:</label>
                    <select class="form-control form-select nueva-clase" name="IdCategoria" id="IdCategoria"  required>
                        <?php foreach ($categorias as $categoria) : ?>
                            <option value="<?= $categoria['IdCategoría'] ?>"><?= $categoria['NombreCategoría'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <button type="button" class="btn btn-success w-100" id="subirImagenBtn">Subir Imagen</button>
                    <input type="file" name="imagenProducto" id="imagenProducto" accept="image/*" class="d-none" required>
                </div>
                <div class="col-md-6 mb-3">
                    <button type="button" id="eliminarImagen" class="btn btn-danger w-100" style="display: none;">Eliminar Imagen</button>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mb-3">
                    <div class="d-flex justify-content-center align-items-center" style="height: 200px; ">
                        <img src="#" id="previewImagen" style="max-width: 100%; max-height: 100%; display: none;" alt="Vista previa">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 text-center">
                    <input type="submit" onclick="addPlatilloForm()" class="btn btn-danger" value="Guardar">
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    // Script para subir imagen y mostrar vista previa
    const subirImagenBtn = document.getElementById('subirImagenBtn');
    const imagenProducto = document.getElementById('imagenProducto');
    const previewImagen = document.getElementById('previewImagen');
    const eliminarImagenBtn = document.getElementById('eliminarImagen');

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
                eliminarImagenBtn.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });

    eliminarImagenBtn.onclick = function() {
        imagenProducto.value = "";
        previewImagen.src = "";
        previewImagen.style.display = 'none';
        this.style.display = 'none';
    };
</script>