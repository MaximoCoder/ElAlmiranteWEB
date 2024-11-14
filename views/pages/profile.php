<!-- PAGINA DE PERFIL PARA LOS USUARIOS -->

<div class="container py-5">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col">
            <h1 class=" fw-bold text-uppercase">¡HOLA, <?php echo htmlspecialchars($user['Nombre']); ?>!</h1>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row">
        <!-- Left Sidebar -->
        <div class="col-md-3 mb-4">
            <div class="list-group">
                <a href="#settings" class="list-group-item list-group-item-action active" data-section="settings">Ajustes de la cuenta</a>
                <a href="#orders" class="list-group-item list-group-item-action" data-section="orders">Historial de pedidos</a>
            </div>
        </div>

        <div class="col-md-9">
            <!-- Settings Section -->
            <div id="settings-section" class="content-section active">
                <div class="card border-0">
                    <div class="card-body">
                        <h2 class="card-title h4 mb-4">AJUSTES DE LA CUENTA</h2>

                        <!-- Personal Information -->
                        <section class="mb-5">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h3 class="h5">INFORMACIÓN PERSONAL</h3>
                                <!--<button class="btn btn-link">EDITAR</button>-->
                            </div>
                            <div class="mb-3">
                                <p class="mb-1"><?php echo htmlspecialchars($user['Nombre']); ?></p>
                                <p class="mb-1"><?php echo $user['Correo']; ?></p>
                            </div>
                        </section>

                        <!-- Delete Account -->
                        <div class="text-center mt-4">
                            <a href="../auth/logout" class="btn btn-danger d-block w-100 mt-4">Cerrar sesion</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Orders Section -->
            <div id="orders-section" class="content-section">
                <h2 class="h4 mb-4">PEDIDOS ANTERIORES</h2>

                <?php if (!empty($orderHistory)): ?>
                    <?php
                    $currentOrderId = null;
                    $orderItems = [];
                    ?>

                    <?php foreach ($orderHistory as $item): ?>
                        <?php if ($currentOrderId !== $item['order_id']): ?>
                            <?php
                            // Display previous order if exists
                            if ($currentOrderId !== null && !empty($orderItems)): ?>
                                <div class="card order-card mb-3">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <!-- ASIGNAR DESC NUMERO DE ORDEN -->
                                                <h3 class="h5 fw-bold mb-1">Orden #<?php echo htmlspecialchars($currentOrderId); ?></h3>
                                                <p class="text-muted mb-2">
                                                    <?php echo count($orderItems) . ' artículo(s)'; ?>
                                                </p>
                                                <p class="text-muted mb-2">
                                                    <?php echo date('d/m/Y H:i', strtotime($orderItems[0]['order_date'])); ?>
                                                </p>

                                                <!-- Order Items -->
                                                <div class="small">
                                                    <?php foreach ($orderItems as $orderItem): ?>
                                                        <div>
                                                            <?php echo htmlspecialchars($orderItem['product_name']); ?>
                                                            x <?php echo $orderItem['quantity']; ?>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                            <div class="col-md-4 text-end">
                                                <p class="fw-bold mb-2">
                                                    Total: $<?php echo number_format($orderItems[0]['MontoTotal'], 2); ?>
                                                </p>

                                                <!-- BOTON PARA VOLVER A PEDIR -->
                                                <button class="btn btn-danger mt-3 reorder-btn" data-order-id="<?php echo htmlspecialchars($currentOrderId); ?>">Volver a ordenar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php
                            // Start new order
                            $currentOrderId = $item['order_id'];
                            $orderItems = [];
                            ?>
                        <?php endif; ?>

                        <?php $orderItems[] = $item; ?>
                    <?php endforeach; ?>

                    <?php
                    // Display last order
                    if (!empty($orderItems)): ?>
                        <div class="card order-card mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h3 class="h5 fw-bold mb-1">Orden #<?php echo htmlspecialchars($currentOrderId); ?></h3>
                                        <p class="text-muted mb-2">
                                            <?php echo count($orderItems) . ' artículo(s)'; ?>
                                        </p>
                                        <p class="text-muted mb-2">
                                            <?php echo date('d/m/Y H:i', strtotime($orderItems[0]['order_date'])); ?>
                                        </p>

                                        <!-- Order Items -->
                                        <div class="small">
                                            <?php foreach ($orderItems as $orderItem): ?>
                                                <div>
                                                    <?php echo htmlspecialchars($orderItem['product_name']); ?>
                                                    x <?php echo $orderItem['quantity']; ?>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <p class="fw-bold mb-2">
                                            Total: $<?php echo number_format($orderItems[0]['MontoTotal'], 2); ?>
                                        </p>

                                        <!-- BOTON PARA VOLVER A PEDIR -->
                                        <button class="btn btn-danger mt-3 reorder-btn" data-order-id="<?php echo htmlspecialchars($currentOrderId); ?>">Volver a ordenar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="alert alert-info">
                        No hay pedidos anteriores para mostrar.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
