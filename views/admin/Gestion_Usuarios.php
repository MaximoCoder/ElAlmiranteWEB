<div class="container mt-4">
    <h2 class="mb-3 text-center">Gestión de Usuarios</h2>
    <div class="table-responsive">
        <?php if (!empty($usuarios)): ?>
            <table class="table table-bordered table-hover table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Nombre</th>
                        <th scope="col">Correo</th>
                        <th scope="col">Fecha de Creación</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Rol</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $usuario): ?>
                        <tr>
                            <td><?= htmlspecialchars($usuario['Nombre']); ?></td>
                            <td><?= htmlspecialchars($usuario['Correo']); ?></td>
                            <td><?= htmlspecialchars($usuario['FechaCreacion']); ?></td>
                            <td>
                                <span class="badge <?= $usuario['Estado'] ? 'bg-success' : 'bg-secondary'; ?>">
                                    <?= $usuario['Estado'] ? 'Activo' : 'Inactivo'; ?>
                                </span>
                            </td>
                            <td><?= $usuario['NombreRol'] ? htmlspecialchars($usuario['NombreRol']) : 'Sin rol'; ?></td>
                            <td>
                                <div class="d-flex gap-2">
                                    <?php if ($usuario['NombreRol']): ?>
                                        <button class="btn btn-sm btn-warning" onclick="abrirModalQuitarRol(<?= $usuario['IdUsuario']; ?>, '<?= htmlspecialchars($usuario['NombreRol']); ?>')">
                                            Quitar Rol
                                        </button>
                                    <?php else: ?>
                                        <button class="btn btn-sm btn-info" onclick="abrirModalAsignarRol(<?= $usuario['IdUsuario']; ?>)">
                                            Asignar Rol
                                        </button>
                                    <?php endif ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-center text-muted">No hay usuarios registrados.</p>
        <?php endif; ?>
    </div>
</div>

<!-- Modal para asignar rol -->
<div class="modal fade" id="asignarRolModal" tabindex="-1" aria-labelledby="asignarRolLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formAsignarRol" onsubmit="return asignarRol(event)">
                <input type="hidden" id="idUsuarioAsignar" name="idUsuario">
                <div class="modal-header">
                    <h5 class="modal-title" id="asignarRolLabel">Asignar Rol al Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="rolAsignar" class="form-label">Seleccionar Rol</label>
                        <select class="form-select" id="rolAsignar" name="rolAsignar" required>
                            <option value="">Selecciona un rol...</option>
                            <?php foreach ($roles as $rol): ?>
                                <option value="<?= $rol['IdRol']; ?>"><?= htmlspecialchars($rol['NombreRol']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success"><i class="bi bi-check-circle"></i> Asignar Rol</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para quitar rol -->
<div class="modal fade" id="quitarRolModal" tabindex="-1" aria-labelledby="quitarRolLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="quitarRolLabel">Quitar Rol del Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro que deseas quitar el rol <strong id="nombreRolQuitar"></strong> de este usuario?</p>
                <input type="hidden" id="idUsuarioQuitar">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" onclick="quitarRol()">Quitar Rol</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<script>
    function asignarRol(event) {
        event.preventDefault();

        const idUsuario = document.getElementById("idUsuarioAsignar").value;
        const rolAsignado = document.getElementById("rolAsignar").value;

        $.ajax({
            url: '/admin/Gestion_Usuarios/asignarRol',
            method: 'POST',
            data: JSON.stringify({
                idUsuario: idUsuario,
                idRol: rolAsignado
            }),
            contentType: 'application/json',
            success: function(response) {
                const modal = bootstrap.Modal.getInstance(document.getElementById('asignarRolModal'));
                modal.hide();

                if (response.status === 'success') {
                    console.log(response);
                    Swal.fire({
                        title: "¡Éxito!",
                        text: "Rol asignado correctamente.",
                        icon: "success",
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        title: "Error",
                        text: response.message || "Hubo un error al asignar el rol.",
                        icon: "error"
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error("Error:", error);
                Swal.fire({
                    title: "Error",
                    text: "Hubo un error al procesar la solicitud.",
                    icon: "error"
                });
            }
        });

        return false;
    }

    function quitarRol() {
        const idUsuario = document.getElementById("idUsuarioQuitar").value;

        $.ajax({
            url: '/admin/Gestion_Usuarios/quitarRol',
            method: 'POST',
            data: JSON.stringify({
                idUsuario: idUsuario
            }),
            contentType: 'application/json',
            success: function(response) {
                const modal = bootstrap.Modal.getInstance(document.getElementById('quitarRolModal'));
                modal.hide();

                if (response.status === 'success') {
                    Swal.fire({
                        title: "¡Éxito!",
                        text: "Rol eliminado correctamente.",
                        icon: "success",
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        title: "Error",
                        text: response.message || "Hubo un error al quitar el rol.",
                        icon: "error"
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error("Error:", error);
                Swal.fire({
                    title: "Error",
                    text: "Hubo un error al procesar la solicitud.",
                    icon: "error"
                });
            }
        });
    }

    function abrirModalAsignarRol(idUsuario) {
        document.getElementById('idUsuarioAsignar').value = idUsuario;
        document.getElementById('rolAsignar').value = "";
        const modal = new bootstrap.Modal(document.getElementById('asignarRolModal'));
        modal.show();
    }

    function abrirModalQuitarRol(idUsuario, nombreRol) {
        document.getElementById('idUsuarioQuitar').value = idUsuario;
        document.getElementById('nombreRolQuitar').textContent = nombreRol;
        const modal = new bootstrap.Modal(document.getElementById('quitarRolModal'));
        modal.show();
    }
</script>