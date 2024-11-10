<?php
session_start();
?>
<div class="container mt-5 card-Cart mb-5">
    <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) { ?>
        <div class="row">
            <div class="col-12">
                <h1 class="mt-4 fw-bold text-center">FINALIZA TU PEDIDO</h1>
            </div>
            <div class="col-12 mt-4">
                <h3 class="fw-bold">PARA RECOGER EN EL RESTAURANTE</h3>
                <h5>Pesqueria, N.L.</h5>
                <p>Mariscos El almirante, 66670 Valle de Santa María, N.L.</p>
            </div>
            <br>
            <hr>
            <div class="col-12">
                <div class="row d-flex justify-content-between align-items-center">
                    <div class="col">
                        <h3 class="fw-bold">DETALLES DEL PEDIDO</h3>
                    </div>
                    <div class="col text-end">
                        <button class="btn-red"><a class="text-decoration-none" href="../pages/menu">Añadir más</a></button>
                    </div>
                </div>
                <!-- CARD DE PRODUCTOS -->
                <div class="mt-4">
                    <?php foreach ($_SESSION['cart'] as $product) { ?>
                        <div class="card-prod mt-4">
                            <div class="row d-flex align-items-center justify-content-between">
                                <div class="col">
                                    <h4 class="fw-bolder name-Product-cart">
                                        <a href="../pages/platillo-<?php echo $product['id']; ?>">
                                            <?php echo htmlspecialchars($product['name']); ?>
                                        </a>
                                    </h4>
                                </div>
                                <div class="col text-end">
                                    <h6>$ <?php echo number_format($product['price'], 2); ?></h6>
                                </div>
                            </div>
                            <div class="quantity-control">
                                <button class="btn btn-decrement" onclick="decreaseQuantity(<?php echo $product['id']; ?>)">−</button>
                                <div class="quantity-display" id="quantity-<?php echo $product['id']; ?>"><?php echo $product['quantity']; ?></div>
                                <button class="btn btn-increment" onclick="increaseQuantity(<?php echo $product['id']; ?>)">+</button>
                            </div>
                            <div class="row d-flex align-items-center justify-content-between">
                                <div class="box-total col-10">
                                    <h5 class="fw-bold">Total: $ <?php echo number_format($product['price'] * $product['quantity'], 2); ?></h5>
                                </div>
                                <div class="col text-end">
                                    <i class="bi bi-trash fs-4 delete" onclick="removeFromCart(<?php echo $product['id']; ?>)"></i>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <br>
                <hr>
                <!-- TOTAL DE PEDIDO -->
                <?php
                $total = 0;
                foreach ($_SESSION['cart'] as $product) {
                    $total += $product['price'] * $product['quantity'];
                }
                ?>
                <div class="col-12 mt-4">
                    <div class="row d-flex justify-content-between align-items-center">
                        <div class="col">
                            <h5 class="fw-bold">Total:</h5>
                        </div>
                        <div class="col text-end">
                            <h5 class="fw-bold">$ <?php echo number_format($total, 2); ?></h5>
                        </div>
                    </div>

                    <h6>Agregar comentarios</h6>
                    <form id="comment-form">
                        <input type="text" class="form-control" placeholder="Agrega cualquier comentario sobre tu pedido aqui" id="comment-input" name="comment" value="<?php echo isset($_POST["comment"]) ? $_POST["comment"] : ''; ?>">
                    </form>
                </div>
                <br>
                <hr>
                <!-- METODOS DE PAGO -->
                <div class="col-12">
                    <h3 class="mt-4 fw-bold">METODOS DE PAGO</h3>
                    <div class="container my-5">
                        <div class="payment-option selected mb-3">
                            <input class="form-check-input" type="radio" name="paymentMethod" id="option1" checked value="option1">
                            <i class="bi bi-wallet icon"></i>
                            <label class="form-check-label" for="option1">
                                <strong>PAGO EN EL RESTAURANTE: EFECTIVO O TARJETA DE CRÉDITO/DÉBITO</strong>
                            </label>
                        </div>
                        <div class="payment-option">
                            <input class="form-check-input" type="radio" name="paymentMethod" id="option2" value="option2">
                            <i class="bi bi-credit-card-2-front icon"></i>
                            <label class="form-check-label" for="option2">
                                <strong>PAGO EN LÍNEA: PAYPAL</strong><br>
                            </label>
                        </div>
                    </div>
                </div>
                <!-- FINALIZAR PEDIDO -->
                <div class="col-12 my-5 text-center">
                    <button class="btn btn-finalizar" onclick="checkout()" id="checkout-button">
                        FINALIZAR PEDIDO
                        <span class="price">$ <?php echo number_format($total, 2); ?></span>
                    </button>

                    <!-- Botón de PayPal solo visible para pagos en línea -->
                    <div id="paypal-button-container" class="paypal-container" style="display: none;"></div>

                </div>
            </div>
        </div>
    <?php } else { ?>
        <div class="row">
            <div class="col-12 text-center py-5">
                <h3 class="fw-bold">No hay productos agregados en tu carrito todavía</h3>
                <div class="mt-4">
                    <button class="btn-red"><a class="text-decoration-none" href="../pages/menu">Ir al menu</a></button>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
<!-- llama al client id de .env -->
<script src="https://www.paypal.com/sdk/js?client-id=<?php echo $_ENV['PAYPAL_CLIENT_ID']; ?>&currency=MXN"></script>
<script>
    document.querySelectorAll('.payment-option').forEach(option => {
        option.addEventListener('click', function() {
            document.querySelectorAll('.payment-option').forEach(opt => opt.classList.remove('selected'));
            this.classList.add('selected');
            this.querySelector('input').checked = true;

            // Mostrar u ocultar el botón de PayPal según la opción seleccionada
            const paypalButtonContainer = document.getElementById('paypal-button-container');
            paypalButtonContainer.style.display = this.querySelector('input').value === 'option2' ? 'block' : 'none';

            // Ocultar el otro boton
            const checkoutButton = document.getElementById('checkout-button');
            checkoutButton.style.display = this.querySelector('input').value === 'option1' ? 'block' : 'none';
        });
    });

    // Configurar el botón de PayPal
    paypal.Buttons({
        createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: <?php echo json_encode($total); ?>
                    }
                }]
            });
        },
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(orderData) {
                registrarCompra(orderData);
            });
        }
    }).render('#paypal-button-container');

    // Función para registrar la compra
    function registrarCompra(datos) {
        const url = '/checkout/paypal';
        const http = new XMLHttpRequest();
        const observaciones = document.getElementById('comment-input').value;

        http.open('POST', url, true);
        http.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
        http.send(JSON.stringify({
            pedidos: datos,
            productos: <?php echo json_encode($_SESSION['cart']); ?>,
            observaciones: observaciones
        }));

        http.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                const response = JSON.parse(this.responseText);
                if (response.status === 'success') {
                    // Limpiar carrito en el frontend
                    sessionStorage.removeItem('cart');
                    // Show success message and redirect to ticket
                    Swal.fire({
                        position: "center",
                        title: "Pago completado",
                        text: "Redirigiendo a su ticket...",
                        icon: "success",
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        window.location.href = response.redirect_url;
                    });
                } else {
                    // Muestra el mensaje de error que proviene del servidor
                    console.error(response.message);
                    Swal.fire({
                        position: "top-end",
                        toast: true,
                        title: "Oops...",
                        text: response.message,
                        icon: "error",
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            }
        };
    }
</script>