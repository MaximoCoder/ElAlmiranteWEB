
<div class="content-wrapper"> 
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-md-12">
                    <div class="m-0 text-dark text-center text-lg">
                        <h1><i class="fas fa-utensils"></i>&nbsp;&nbsp;Registro de Platillos</h1>

<div class="container mt-4 card-add-product  ">
    <div class="text-white  ">
        <form  id="platillo-form">
            <h3 class="text-center text-black">Agregar Platillo</h3>
            <div class="row">
                <div class="col-lg-8 mb-3">
                    <label for="nombrePlatillo" class="form-label text-black">Nombre del Producto:</label>
                    <input type="text" class="form-control border-0  input-color"  name="NombrePlatillo" required>
                </div>
                <div class="col-lg-4 mb-3">
                    <label for="precioPlatillo" class="form-label text-black">Precio:</label>
                    <input type="number" step="1" class="form-control border-0 input-color" name="PrecioPlatillo" required>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 mb-4">
                    <label for="descripcionPlatillo" class="form-label text-black">Descripción:</label>
                    <textarea class="form-control border-0  input-color" name="DescripcionPlatillo"  rows="3" required></textarea>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="disponibilidad" class="form-label text-black">Disponibilidad:</label>
                    <select class="form-control form-select border-0  input-color" name="Disponibilidad"  required>
                        <option value="Disponible">Disponible</option>
                        <option value="No Disponible">No Disponible</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="categoria" class="form-label text-black">Categoría:</label>
                    <select class="form-control form-select border-0 input-color" name="IdCategoria" id="IdCategoria"  required>
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
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div style="max-width: 1140px;margin: 0 auto;">
                <form id="platillo-form">
                    <div class="card card-primary">
                        <div class="card-header">
                            <div class="card-title">Datos del Platillo</div>
                            <div class="float-right" style="height: 2rem; width: 150px">
                                <input type="text" class="form-control" placeholder="ID de platillo" name="producto_codigo" readonly>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="nombrePlatillo" class="form-label">Nombre del Producto:</label>
                                        <input type="text" class="form-control nueva-clase" name="NombrePlatillo" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="precioPlatillo" class="form-label">Precio:</label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" step="0.01" class="form-control nueva-clase" name="PrecioPlatillo" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="DescripciónPlatillo" class="form-label">Descripción:</label>
                                        <textarea class="form-control nueva-clase" name="DescripciónPlatillo" rows="3" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="disponibilidad" class="form-label">Disponibilidad:</label>
                                        <select class="form-control form-select nueva-clase" name="Disponibilidad" required>
                                            <option value="Disponible">Disponible</option>
                                            <option value="No Disponible">No Disponible</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="categoria" class="form-label">Categoría:</label>
                                        <select class="form-control form-select nueva-clase" name="IdCategoría" id="IdCategoría" required>
                                            <?php foreach ($categorias as $categoria) : ?>
                                                <option value="<?= $categoria['IdCategoría'] ?>"><?= $categoria['NombreCategoría'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <button type="button" class="btn btn-success w-100" id="subirImagenBtn">Subir Imagen</button>
                                <input type="file" name="img" id="img" accept="image/*" class="d-none" required>
                            </div>
                            <div class="col-md-6">
                                <button type="button" id="eliminarImagen" class="btn btn-danger w-100" style="display: none;">Eliminar Imagen</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="d-flex justify-content-center align-items-center" style="height: 200px;">
                                    <img src="#" id="previewImagen" style="max-width: 100%; max-height: 100%; display: none;" alt="Vista previa">
                                </div>
                            </div>
                        </div>
                    </div>

                        <div class="col-6 text-right">
                            <input type="submit" onclick="addPlatilloForm()" class="btn btn-danger" value="Guardar Platillo">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Script para subir imagen y mostrar vista previa
    const subirImagenBtn = document.getElementById('subirImagenBtn');
    const img = document.getElementById('img');
    const previewImagen = document.getElementById('previewImagen');
    const eliminarImagenBtn = document.getElementById('eliminarImagen');

    subirImagenBtn.addEventListener('click', () => {
        img.click();
    });

    img.addEventListener('change', (event) => {
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
        img.value = "";
        previewImagen.src = "";
        previewImagen.style.display = 'none';
        this.style.display = 'none';
    };

</script>
