<div class="container mt-5 card-Cart mb-5">
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
                    <button class="btn-red "><a class="text-decoration-none" href="../pages/menu">Añadir más</a></button>
                </div>
            </div>
            <!-- CARD DE PRODUCTOS -->
            <div class="card-prod mt-4">
                <!-- PRODUCTO -->
                <div class="row d-flex align-items-center justify-content-between">
                    <div class="col">
                        <h4 class="fw-bolder">Camarones Empanizados</h4>
                    </div>
                    <div class="col text-end">
                        <h6>$ 10.00</h6>
                    </div>
                </div>
                <div class="quantity-control">
                    <button class="btn btn-decrement" onclick="decreaseQuantity()">−</button>
                    <div class="quantity-display" id="quantity">1</div>
                    <button class="btn btn-increment" onclick="increaseQuantity()">+</button>
                </div>
                <div class=" row d-flex align-items-center justify-content-between">
                    <div class=" box-total col-10">
                        <h5 class="fw-bold">Total: $ 10.00</h5>
                    </div>
                    <div class="col text-end ">
                        <i class="bi bi-trash fs-4"></i>
                    </div>
                </div>
                <!--  FIN PRODUCTO -->
            </div>
            <!-- FIN CARD DE PRODUCTOS -->
            <div class="card-prod mt-4">
                <!-- PRODUCTO -->
                <div class="row d-flex align-items-center justify-content-between">
                    <div class="col">
                        <h4 class="fw-bolder">Camarones Empanizados</h4>
                    </div>
                    <div class="col text-end">
                        <h6>$ 10.00</h6>
                    </div>
                </div>
                <div class="quantity-control">
                    <button class="btn btn-decrement" onclick="decreaseQuantity()">−</button>
                    <div class="quantity-display" id="quantity">1</div>
                    <button class="btn btn-increment" onclick="increaseQuantity()">+</button>
                </div>
                <div class=" row d-flex align-items-center justify-content-between">
                    <div class=" box-total col-10">
                        <h5 class="fw-bold">Total: $ 10.00</h5>
                    </div>
                    <div class="col text-end ">
                        <i class="bi bi-trash fs-4"></i>
                    </div>
                </div>
                <!--  FIN PRODUCTO -->
            </div>
            <br>
            <hr>
            <!-- TOTAL DE PEDIDO -->
            <div class="col-12 mt-4">
                <div class="row d-flex justify-content-between align-items-center">
                    <div class="col">
                        <h5 class="fw-bold">Total:</h5>
                    </div>
                    <div class="col text-end">
                        <h5 class="fw-bold">$ 20.00</h5>
                    </div>
                </div>

                <h6>Agregar comentarios</h6>
                <form action="">
                    <input type="text" class="form-control" placeholder="Agrega cualquier comentario sobre tu pedido aqui">
                </form>
            </div>
            <!-- FIN TOTAL DE PEDIDO -->
            <br>
            <hr>
            <!-- METODOS DE PAGO -->
            <div class="col-12">
                <h3 class="mt-4 fw-bold ">METODOS DE PAGO</h3>

                <div class="container my-5">
                    <!-- Opción 1 -->
                    <div class="payment-option selected mb-3">
                        <input class="form-check-input" type="radio" name="payment" id="option1" checked>
                        <i class="bi bi-wallet icon"></i>
                        <label class="form-check-label" for="option1">
                            <strong>PAGO EN EL RESTAURANTE: EFECTIVO O TARJETA DE CRÉDITO/DÉBITO</strong>
                        </label>
                    </div>
                   
                    <!-- Opción 3 -->
                    <div class="payment-option">
                        <input class="form-check-input" type="radio" name="payment" id="option2">
                        <i class="bi bi-credit-card-2-front icon"></i>
                        <label class="form-check-label" for="option2">
                            <strong>PAGO EN LÍNEA</strong> <br>
                            <small>Débito y Crédito</small>
                        </label>
                    </div>
                </div>
            </div>
            <!-- FIN METODOS DE PAGO -->

            <!-- FINALIZAR PEDIDO -->
            <div class="col-12 my-5 text-center">
                <button class="btn btn-finalizar ">
                    FINALIZAR PEDIDO
                    <span class="price">$169</span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Obtener todas las opciones de pago
    const paymentOptions = document.querySelectorAll('.payment-option');

    // Agregar evento a cada opción de pago
    paymentOptions.forEach(option => {
        option.addEventListener('click', function() {
            // Remover la clase 'selected' de todas las opciones
            paymentOptions.forEach(opt => opt.classList.remove('selected'));

            // Añadir la clase 'selected' a la opción actual
            this.classList.add('selected');

            // Seleccionar el input radio dentro de la opción actual
            this.querySelector('input').checked = true;
        });
    });
</script>