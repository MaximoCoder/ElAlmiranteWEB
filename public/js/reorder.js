$(document).ready(function() {
    $('.reorder-btn').on('click', function() {
        const orderId = $(this).data('order-id');

        // Solicitar productos de la orden mediante AJAX
        $.ajax({
            url: '/reordenar',
            type: 'POST',
            data: {
                order_id: orderId
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    let products = response.orderItems;
                    console.log(products);
                    // Agregar cada producto al carrito
                    products.forEach(product => {
                        $.ajax({
                            url: '/agregar-al-carrito', // URL del método manageCart
                            type: 'POST',
                            data: {
                                encrypted_data: product.encrypted_data
                            },
                            dataType: 'json',
                            success: function(cartResponse) {
                                if (cartResponse.status === 'success') {
                                    console.log(cartResponse.message);
                                } else {
                                    console.log(cartResponse.message);
                                }
                            }
                        });
                    });

                    // Redireccionar al carrito después de agregar los productos
                    
                    setTimeout(function() {
                        window.location.href = '/pages/cart';
                    }, 1000);
                } else {
                    // Mostrar mensaje de error xhlr
                    Swal.fire({
                        position: "top-end",
                        toast: true,
                        title: "Error",
                        text: "Error al obtener los productos de la orden.",
                        icon: "error",
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            },
            error: function(xhr) {
                // Mostrar mensaje de error
                console.log("Error al obtener los productos de la orden: " + xhr.responseText);
                Swal.fire({
                    position: "top-end",
                    toast: true,
                    title: "Error",
                    text: "Hubo un problema al procesar la solicitud." + xhr.responseText,
                    icon: "error",
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        });
    });
});