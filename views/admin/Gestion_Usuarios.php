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
                        <td>
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm btn-warning" onclick="editarUsuario(<?= $usuario['IdUsuario']; ?>)">
                                    <i class="bi bi-pencil-square"></i> Editar
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="eliminarUsuario(<?= $usuario['IdUsuario']; ?>)">
                                    <i class="bi bi-trash"></i> Eliminar
                                </button>
                                <button class="btn btn-sm btn-info" onclick="asignarRol(<?= $usuario['IdUsuario']; ?>)">
                                    <i class="bi bi-person-plus"></i> Asignar Rol
                                </button>
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

    <h2 class="mt-5 mb-3 text-center">Gestión de Roles</h2>
    <div class="table-responsive">
        <?php if (!empty($roles)): ?>
            <table class="table table-bordered table-hover table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Nombre del Rol</th>
                        <th scope="col">Descripción</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($roles as $rol): ?>
                    <tr>
                        <td><?= htmlspecialchars($rol['NombreRol']); ?></td>
                        <td><?= htmlspecialchars($rol['DescripciónRol']); ?></td>
                        <td>
                            <button class="btn btn-sm btn-danger" onclick="eliminarRol(<?= $rol['IdRol']; ?>)">
                                <i class="bi bi-trash"></i> Eliminar
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-center text-muted">No hay roles disponibles.</p>
        <?php endif; ?>
    </div>
    <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#agregarRolModal">
        <i class="bi bi-plus-circle"></i> Agregar Nuevo Rol
    </button>
</div>

<!-- Modal para agregar rol -->
<div class="modal fade" id="agregarRolModal" tabindex="-1" aria-labelledby="agregarRolLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formAgregarRol">
                <div class="modal-header">
                    <h5 class="modal-title" id="agregarRolLabel">Agregar Nuevo Rol</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nombreRol" class="form-label">Nombre del Rol</label>
                        <input type="text" class="form-control" id="nombreRol" required>
                    </div>
                    <div class="mb-3">
                        <label for="descripciónRol" class="form-label">Descripción del Rol</label>
                        <textarea class="form-control" id="descripciónRol" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>