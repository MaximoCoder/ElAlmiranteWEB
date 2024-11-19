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
<!-- NAVBAR -->
<main>
    <div class="container-fluid">
        <h1>Categorias</h1>
        <div class="">
        <form id="form-agregar-categoria" class="box-reusable" onsubmit="event.preventDefault(); agregarCategoria();">
            <div class="mb-3 bg-form text-white p-5 rounded">
                <label class="text-black" for="nombreCategoria">Nombre de Categoría:</label>
                <input type="text" id="nombreCategoria" name="nombreCategoria" class="form-control input-formU nueva-clase" required>

                <label class="text-black mt-3" for="estadoCategoria">Estado:</label>
                <select id="estadoCategoria" name="estadoCategoria" class="form-control nueva-clase" required>
                    <option value="Activa">Activa</option>
                    <option value="Inactiva">Inactiva</option>
                </select>

                <input type="submit" value="Agregar Categoría" class="btn-reuse mt-3">
            </div>
        </form>


            <div class="table-data">
                <div class="order">
                    <div class="head">
                        <h3>Categorias</h3>
                        <i class='bx bx-search'></i>
                        <i class='bx bx-filter'></i>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre de Categoría</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categorias as $categoria): ?>
                                <tr data-id="<?= $categoria['IdCategoría']; ?>">
                                    <td><?= $categoria['IdCategoría']; ?></td>
                                    <td><?= htmlspecialchars($categoria['NombreCategoría']); ?></td>
                                    <td><?= htmlspecialchars($categoria['Estado']); ?></td>
                                    <td>
                                        <a href="#" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editarCategoriaModal"
                                        onclick="abrirModalEditar(<?= $categoria['IdCategoría']; ?>, '<?= htmlspecialchars($categoria['NombreCategoría']); ?>', '<?= htmlspecialchars($categoria['Estado']); ?>')">
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
</main>

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

                        <label for="estadoCategoriaEditar" class="form-label mt-3">Estado</label>
                        <select name="estadoCategoriaEditar" id="estadoCategoriaEditar" class="form-control" required>
                            <option value="Activa">Activa</option>
                            <option value="Inactiva">Inactiva</option>
                        </select>
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
    function agregarCategoria() {
    const nombreCategoria = document.getElementById('nombreCategoria').value;
    const estadoCategoria = document.getElementById('estadoCategoria').value;

    const datos = {
        nombreCategoria: nombreCategoria,
        estadoCategoria: estadoCategoria
    };

    fetch('/admin/Categorias-add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(datos)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                title: "Éxito",
                text: data.message,
                icon: "success",
                confirmButtonColor: '#3085d6'
            }).then(() => {
                // Agregar la nueva categoría a la tabla
                const nuevaCategoria = document.createElement('tr');
                nuevaCategoria.innerHTML = `
                    <td>${data.id}</td>
                    <td>${nombreCategoria}</td>
                    <td>${estadoCategoria}</td>
                    <td>
                        <a href="#" class="btn btn-warning" onclick="editarCategoria(${data.id}, '${nombreCategoria}', '${estadoCategoria}')">Editar</a>
                        <a href="#" class="btn btn-danger" onclick="eliminarCategoria(${data.id})">Eliminar</a>
                    </td>
                `;
                document.querySelector('table tbody').appendChild(nuevaCategoria);
                document.getElementById('nombreCategoria').value = ''; // Limpiar campo
            });
        } else {
            Swal.fire({
                title: "Error",
                text: data.message,
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

    function abrirModalEditar(id, nombre, estado) {
    document.getElementById('categoriaId').value = id;
    document.getElementById('nombreCategoriaEditar').value = nombre;
    document.getElementById('estadoCategoriaEditar').value = estado;
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
                title: "Error",
                text: data.message || "Hubo un problema al editar la categoría.",
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