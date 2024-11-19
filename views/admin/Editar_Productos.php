<!-- NAVBAR -->
<nav>
       <i class='bx bx-menu'></i>
       
       <form action="#">
           <div class="form-input">
               
               <button><i class='bx bx-search'></i></button>
           </div>
       </form>
       <input type="checkbox" id="switch-mode" hidden>
       <label for="switch-mode" class="switch-mode"></label>

   </nav>
    <div class="content">
        <div class="container-fluid">
    <div class="container-fluid">
        <h1>Editar Platillos</h1>


                    <div class="table-responsive">
                        <table id="table-platillos" class="table" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Precio</th>
                                    <th>Disponibilidad</th>
                                    <th>Imagen</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($platillos as $platillo): ?>
                                    <tr data-id="<?= $platillo['IdPlatillo']; ?>">
                                        <td class="nombre-platillo"><?= htmlspecialchars($platillo['NombrePlatillo']); ?></td>
                                        <td class="descripcion-platillo"><?= htmlspecialchars($platillo['DescripcionPlatillo']); ?></td>
                                        <td class="precio-platillo"><?= htmlspecialchars($platillo['PrecioPlatillo']); ?></td>
                                        <td class="disponibilidad-platillo"><?= $platillo['Disponibilidad'] ? 'Disponible' : 'No Disponible'; ?></td>

                                            <td>
                                                <?php if (!empty($platillo['img'])): ?>
                                                    <img src="/uploads/<?= htmlspecialchars($platillo['img']); ?>" alt="<?= htmlspecialchars($platillo['NombrePlatillo']); ?>" style="width: 50px; height: auto;">
                                                <?php else: ?>
                                                    <p>No hay imagen disponible</p>
                                                <?php endif; ?>
                                            </td>

                                        <td>
                                            <a href="#" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editarPlatilloModal"
                                               onclick="abrirModalEditar(<?= $platillo['IdPlatillo']; ?>, '<?= htmlspecialchars($platillo['NombrePlatillo']); ?>', '<?= htmlspecialchars($platillo['DescripcionPlatillo']); ?>', '<?= htmlspecialchars($platillo['PrecioPlatillo']); ?>', '<?= htmlspecialchars($platillo['Disponibilidad']); ?>')"><i class='bx bxs-edit'></i></a>
                                            <a href="#" class="btn btn-danger" onclick="eliminarPlatillo(<?= $platillo['IdPlatillo']; ?>)"><i class='bx bxs-trash'></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

<div class="modal fade" id="editarPlatilloModal" tabindex="-1" aria-labelledby="editarPlatilloLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <form id="form-editar-platillo" enctype="multipart/form-data" onsubmit="event.preventDefault(); editarPlatillo();">
        <div class="modal-header">
                    <h5 class="modal-title" id="editarPlatilloLabel">Editar Platillo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="platilloId" id="platilloId">
                    
                    <div class="mb-3">
                        <label for="nombrePlatilloEditar" class="form-label">Nombre de Platillo</label>
                        <input type="text" name="nombrePlatilloEditar" id="nombrePlatilloEditar" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="descripcionPlatilloEditar" class="form-label">Descripción de Platillo</label>
                        <textarea name="descripcionPlatilloEditar" id="descripcionPlatilloEditar" class="form-control" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="precioPlatilloEditar" class="form-label">Precio</label>
                        <input type="number" name="precioPlatilloEditar" id="precioPlatilloEditar" class="form-control" step="0.01" required>
                    </div>

                    <div class="mb-3">
                        <label for="disponibilidadPlatilloEditar" class="form-label">Disponibilidad</label>
                        <select name="disponibilidadPlatilloEditar" id="disponibilidadPlatilloEditar" class="form-select" required>
                            <option value="Disponible">Disponible</option>
                            <option value="No Disponible">No Disponible</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="categoriaPlatilloEditar" class="form-label">Categoría</label>
                        <select name="categoriaPlatilloEditar" id="categoriaPlatilloEditar" class="form-select" required>
                            <?php foreach ($categorias as $categoria): ?>
                                <option value="<?= $categoria['IdCategoría']; ?>"><?= htmlspecialchars($categoria['NombreCategoría']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div>
                        <label for="imagenExistente">Imagen Actual o cambiar imagen</label><br>
                        <?php if (!empty($platillo['img'])): ?>
                            <img id="imagenExistente" src="/uploads/<?= htmlspecialchars($platillo['img']); ?>" alt="<?= htmlspecialchars($platillo['NombrePlatillo']); ?>" style="width: 150px; height: auto;">
                        <?php else: ?>
                            <p>No hay imagen disponible</p>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="imgPlatilloEditar">Subir nueva imagen (opcional)</label>
                        <input type="file" id="imgPlatilloEditar" name="imgPlatilloEditar" class="form-control" required>

                    </div>
                    <input type="hidden" id="imagenExistente" name="imagenActual">

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="editarPlatillo()">Guardar cambios</button>                </div>
            </form>
        </div>
    </div>
</div>

 

<script>
    function abrirModalEditarPlatillo(platilloId) {
    $.ajax({
        url: '/admin/ObtenerPlatillos' + platilloId,
        method: 'GET',
        success: function(data) {
            $('#platilloId').val(data.IdPlatillo);
            $('#nombrePlatilloEditar').val(data.NombrePlatillo);
            $('#descripcionPlatilloEditar').val(data.DescripcionPlatillo);
            $('#precioPlatilloEditar').val(data.PrecioPlatillo);
            
            $('#imagenActual').attr('src', '/uploads/' + data.img);

            $('#modalEditarPlatillo').modal('show');
        },
        error: function() {
            alert('Error al cargar los datos del platillo');
        }
    });
}

function eliminarPlatillo(id) {
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
            fetch(`/admin/platillos/eliminar?id=${id}`, {
                method: 'DELETE',
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: "Eliminado",
                        text: "El platillo ha sido eliminado exitosamente.",
                        icon: "success",
                        confirmButtonColor: '#3085d6' 
                    }).then(() => {
                        location.reload(); 
                    });
                } else {
                    Swal.fire({
                        title: "Oops...",
                        text: "Error al eliminar el platillo: " + data.error,
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

    function abrirModalEditar(id, nombre, descripcion, precio, disponibilidad, categoriaId, imagen) {
    document.getElementById('platilloId').value = id;
    document.getElementById('nombrePlatilloEditar').value = nombre;
    document.getElementById('descripcionPlatilloEditar').value = descripcion;
    document.getElementById('precioPlatilloEditar').value = precio;
    document.getElementById('disponibilidadPlatilloEditar').value = disponibilidad;
    document.getElementById('categoriaPlatilloEditar').value = categoriaId;
    document.getElementById('imagenExistente').value = imagen; 

    const imagenActual = document.getElementById('imagenActual');
    if (imagen) {
        imagenActual.src = '/uploads/' + imagen;
    } else {
        imagenActual.src = ''; 
    }
}



function editarPlatillo() {
    const form = document.getElementById('form-editar-platillo');
    const formData = new FormData(form);

    const imgPlatillo = document.getElementById('imgPlatilloEditar').files[0];
    const imagenExistente = document.getElementById('imagenExistente').value;

    if (!imgPlatillo) {
        formData.append('imgPlatilloEditar', imagenExistente);
    } else {
        formData.append('imagenExistente', imgPlatillo);
    }

    fetch('/admin/platillos/editar', {
        method: 'POST',
        body: formData,
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`Error en la respuesta del servidor: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            Swal.fire({
                title: "Éxito",
                text: "Platillo modificado exitosamente.",
                icon: "success"
            }).then(() => {
                location.reload();
            });
        } else {
            Swal.fire({
                title: "Oops...",
                text: "Error al modificar el platillo: " + data.error,
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


$(document).ready(function() {
    $('#formEditarPlatillo').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            type: 'POST',
            url: '/admin/platillos/editar',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        title: "Éxito",
                        text: "Platillo actualizado exitosamente.",
                        icon: "success"
                    }).then(() => {
                        $('#imagenActual').attr('src', '/uploads/' + response.imagen);
                        $('#nombrePlatillo').text(response.nombre);
                        $('#categoriaPlatillo').text(response.categoria);
                        $('#disponibilidadPlatillo').text(response.disponibilidad);
                        $('#descripcionPlatillo').text(response.descripcion);
                        $('#precioPlatillo').text(response.precio);
                    });
                } else {
                    Swal.fire({
                        title: "Oops...",
                        text: response.error || "Hubo un problema al actualizar el platillo.",
                        icon: "error"
                    });
                }
            },
            error: function() {
                Swal.fire({
                    title: "Oops...",
                    text: "Error en la solicitud.",
                    icon: "error"
                });
            }
        });
    });
});


</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
