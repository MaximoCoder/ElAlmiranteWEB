<!-- NAVBAR -->
<nav>
    <i class='bx bx-menu'></i>
</nav>
<!-- NAVBAR -->


<main class="container mt-4">
    <h2 class="mb-3 text-center">Gestión de Pedidos</h2>
    <div class="text-end mb-3">
        <strong>Fecha y hora actual:</strong> <span id="fecha-hora"></span>
    </div>

    <!-- Pedidos Pendientes -->
    <div class="mb-4">
        <h4 class="text-center">Pedidos Pendientes</h4>
        <div class="table-responsive">
            <?php if (!empty($pendientes)): ?>
                <table class="table table-bordered table-hover table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">ID Orden</th>
                            <th scope="col">Monto Total</th>
                            <th scope="col">Estado de Pago</th>
                            <th scope="col">Platillos</th>
                            <th scope="col">Nota</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pendientes as $pedido): ?>
                            <tr>
                                <td><?= htmlspecialchars($pedido['IdOrden']); ?></td>
                                <td>$<?= number_format($pedido['MontoOrden'], 2); ?></td>
                                <td>
                                    <span class="badge <?= $pedido['EstadoPago'] === 'Completado' ? 'bg-success' : 'bg-warning'; ?>">
                                        <?= htmlspecialchars($pedido['EstadoPago']); ?>
                                    </span>
                                </td>
                                <td><?= htmlspecialchars($pedido['Platillos']); ?></td>
                                <td><?= htmlspecialchars($pedido['Nota']); ?></td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <?php if ($pedido['EstadoPago'] === 'Pendiente'): ?>
                                            <button class="btn btn-sm btn-success" data-id="<?= htmlspecialchars($pedido['IdVenta']); ?>">
                                                Pago Completado
                                            </button>
                                        <?php elseif ($pedido['EstadoPago'] === 'Completado'): ?>
                                            <button class="btn btn-sm btn-primary"
                                                data-id="<?= htmlspecialchars($pedido['IdOrden']); ?>"
                                                data-venta="<?= htmlspecialchars($pedido['IdVenta']); ?>">
                                                Completar Pedido
                                            </button>
                                        <?php endif ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-center text-muted">Todavia no hay pedidos pendientes.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Pedidos Completados -->
    <div>
        <h4 class="text-center">Pedidos Completados</h4>
        <div class="table-responsive">
            <?php if (!empty($completados)): ?>
                <table class="table table-bordered table-hover table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">ID Orden</th>
                            <th scope="col">Monto Total</th>
                            <th scope="col">Estado de Pago</th>
                            <th scope="col">Platillos</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($completados as $pedido): ?>
                            <tr>
                                <td><?= htmlspecialchars($pedido['IdOrden']); ?></td>
                                <td>$<?= number_format($pedido['MontoOrden'], 2); ?></td>
                                <td><?= htmlspecialchars($pedido['EstadoPago']); ?></td>
                                <td><?= htmlspecialchars($pedido['Platillos']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-center text-muted">Todavia no hay pedidos completados.</p>
            <?php endif; ?>
        </div>
    </div>
</main>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Actualizar la fecha y hora
        const actualizarFechaHora = () => {
            const fecha = new Date();
            const opciones = {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            };
            document.getElementById('fecha-hora').textContent = fecha.toLocaleDateString('es-MX', opciones);
        };

        // Actualizar la fecha y hora cada segundo
        actualizarFechaHora();
        setInterval(actualizarFechaHora, 1000);
        // Lógica para marcar el pago como completado
        function PagoCompletado(idVenta) {
            $.ajax({
                url: '/admin/Pedidos-pagado', // Ruta definida en el router
                type: 'PUT', // Método PUT
                data: JSON.stringify({
                    idVenta: idVenta
                }), // Enviar ID de venta como JSON
                contentType: 'application/json; charset=utf-8', // Tipo de contenido
                success: function(response) {
                    Swal.fire({
                        title: "¡Éxito!",
                        text: "Se actualizo el estado de pago.",
                        icon: "success",
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function(xhr, status, error) {
                    // Manejo de errores
                    Swal.fire({
                        title: "Oops...",
                        text: xhr.responseText || "Hubo un problema al actualizar el estado.",
                        icon: "error",
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            });
        }

        function CompletarPedido(idOrden, idVenta) {
            $.ajax({
                url: '/admin/Pedidos-completado',
                type: 'PUT',
                data: JSON.stringify({
                    idOrden: idOrden,
                    idVenta: idVenta
                }), // Enviar ID de la orden como JSON
                contentType: 'application/json; charset=utf-8',
                success: function(response) {
                    Swal.fire({
                        title: "¡Éxito!",
                        text: "El pedido ha sido completado.",
                        icon: "success",
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        title: "Oops...",
                        text: xhr.responseText || "Hubo un problema al completar el pedido.",
                        icon: "error",
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            });
        }
        // Asignar eventos de clic a los botones de pago completado
        $('.btn-success').click(function() {
            const idVenta = $(this).data('id'); // Obtener el ID de venta del atributo data-id
            PagoCompletado(idVenta); // Llamar a la función
        });
        // Asignar eventos de clic a los botones de completar pedido
        $('.btn-primary').click(function() {
            const idOrden = $(this).data('id'); // Obtener el ID de orden
            const idVenta = $(this).data('venta'); // Obtener el ID de venta
            CompletarPedido(idOrden, idVenta); // Pasar ambos valores a la función
        });

    });
</script>