//Funcion para eliminar un producto del carrito
function removeFromCart(id) {
    $.ajax({
        url: '/cart/delete-' + id,
        method: 'POST',
        success: function (response) {
            if (response.status === 'success') {
                Swal.fire({
                    position: "top-end",
                    toast: true,
                    title: "Exito",
                    text: response.message,
                    icon: "success",
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    location.reload();
                });
            } else {
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
        },
        error: function () {
            Swal.fire({
                position: "top-end",
                toast: true,
                title: "Error",
                text: "Hubo un problema al eliminar el producto del carrito.",
                icon: "error",
                showConfirmButton: false,
                timer: 1500
            });
        }
    });
}

// FUNCION PARA AUMENTAR LA CANTIDAD DE UN PRODUCTO EN EL CARRITO
function increaseQuantity(id) {
    let currentQuantity = parseInt($('#quantity-' + id).text()); // Asegúrate de tener un id único para cada producto
    let newQuantity = currentQuantity + 1;
    $.ajax({
        url: '/cart/increase-' + id,
        method: 'POST',
        data: {
            quantity: newQuantity
        },
        success: function (response) {
            if (response.status === 'success') {

                location.reload(); // Recargar la página para ver los cambios

            } else {
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
        },
        error: function () {
            Swal.fire({
                position: "top-end",
                toast: true,
                title: "Error",
                text: "Ocurrio un error.",
                icon: "error",
                showConfirmButton: false,
                timer: 1500
            });
        }
    });
}

// FUNCION PARA DISMINUIR LA CANTIDAD DE UN PRODUCTO EN EL CARRITO
function decreaseQuantity(id) {
    let currentQuantity = parseInt($('#quantity-' + id).text()); // Asegúrate de tener un id único para cada producto
    let newQuantity = currentQuantity - 1;
    $.ajax({
        url: '/cart/decrease-' + id,
        method: 'POST',
        data: {
            quantity: newQuantity
        },
        success: function (response) {
            if (response.status === 'success') {

                location.reload(); // Recargar la página para ver los cambios

            } else {
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
        },
        error: function () {
            Swal.fire({
                position: "top-end",
                toast: true,
                title: "Error",
                text: "Ocurrio un error.",
                icon: "error",
                showConfirmButton: false,
                timer: 1500
            });
        }
    });
}

// FUNCION PARA EL CHECKOUT CON STRIPE API
function checkout() {
    // ENVIAR AL BACKEND LOS DATOS DEL CARRITO

    // Primero diferenciar entre si el user selecciona pago en linea o pago en tienda fisica
    let paymentMethod = $('input[name="paymentMethod"]:checked').val();

    // Obtener observaciones del pedido
    const observaciones = document.getElementById('comment-input').value;

    if (paymentMethod === 'option1') {
        // Si es pago en tienda física
        $.ajax({
            url: '/cart/pago-pendiente',
            method: 'POST',
            data: {
                observaciones: observaciones
            },
            success: function (response) {
                if (response.status === 'success') {
                    // Limpiar carrito en el frontend
                    sessionStorage.removeItem('cart');
                    // Show success message and redirect to ticket
                    Swal.fire({
                        position: "center",
                        title: "Pedido realizado con exito",
                        text: "Redirigiendo a su ticket...",
                        icon: "success",
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        window.location.href = response.redirect_url;
                    });
                } else if (response.message === 'Por favor inicia sesión para proceder al pago.') {
                    // Si el usuario no está logueado, redirigir al login
                    Swal.fire({
                        position: "top-end",
                        toast: true,
                        title: "Oops...",
                        text: response.message,
                        icon: "error",
                        showConfirmButton: false,
                        timer: 1500
                    });
                    setTimeout(() => {
                        window.location.href = '/auth/login'; // Redirigir a la página de login
                    }, 1500);

                }
            },
            // Muestra el mensaje de error que proviene del servidor
            error: function (xhr) {
                Swal.fire({
                    position: "top-end",
                    toast: true,
                    title: "Oops...",
                    text: "Ocurrio un error." + xhr.responseText,
                    icon: "error",
                    showConfirmButton: false,
                    //timer: 1500
                });

            }

        }


        );
    }
}

