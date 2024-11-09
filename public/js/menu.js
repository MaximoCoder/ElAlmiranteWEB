$(document).ready(function () {
    // Función para cargar productos
    function loadProducts(category) {
        // Limpiar el contenedor de la categoría seleccionada
        var containerId = (category === 'all') ? '#products-all' : '#products-' + category;

        // Limpiar el contenedor antes de cargar los nuevos productos
        $(containerId).empty();

        $.ajax({
            url: '/api/platillos', // URL del endpoint de tu API
            method: 'GET',
            data: {
                IdCategoria: category // Enviar IdCategoria para filtrar
            },
            dataType: 'json',
            success: function (data) {
                //console.log(data); // Verifica los datos recibidos en la consola

                if (data.length === 0) {
                    $(containerId).append('<p class="text-center mt-5 fw-bold display-6">No hay productos disponibles en esta categoría.</p>');
                    return;
                }

                // Iterar sobre los productos y agregarlos al DOM
                data.forEach(function (product) {
                    // Limitar la descripción a 100 caracteres y agregar '...' si es más larga
                    var descripcionLimitada = product.DescripcionPlatillo.length > 100
                        ? product.DescripcionPlatillo.substring(0, 100) + '...'
                        : product.DescripcionPlatillo;

                    var productHtml = `
                        <div class="col-lg-3 col-sm-6">
                            <div class="menu-item bg-white shadow-on-hover">
                                <div class="image-container" style="width: 100%; height: 200px; overflow: hidden;">
                                    <img src="../uploads/${product.img}" class="img-fluid w-100 h-100 object-fit-cover" alt="${product.NombrePlatillo}">
                                </div>
                                <div class="menu-item-content p-4">
                                    <h5 class="mt-1 mb-2 name-Product"><a href="../pages/platillo-${product.IdPlatillo}">${product.NombrePlatillo}</a></h5>
                                    <p class="small">${descripcionLimitada}</p>
                                    <div class="d-flex justify-content-end">
                                        <span class="fw-bold">Precio - $${product.PrecioPlatillo}</span>
                                    </div>
                                    <button class="btn btn-menu d-block w-100 addToCart" data-id="${product.IdPlatillo}" data-name="${product.NombrePlatillo}" data-price="${product.PrecioPlatillo}"><i class="bi bi-cart-plus fs-4"></i></button>
                                </div>
                            </div>
                        </div>
                    `;
                    //console.log('Insertando producto en contenedor: ', containerId);
                    $(containerId).append(productHtml);
                });
                // Añadir evento a los botones del carrito
                $('.addToCart').on('click', function () {
                    var productId = $(this).data('id');
                    var productName = $(this).data('name');
                    var productPrice = $(this).data('price');

                    // Encriptar y enviar los datos del producto
                    submitEncryptedForm(productId, productName, productPrice);
                });
            },
            error: function (xhr, status, error) {
                //console.error('Error al obtener los productos:', error);
                $(containerId).append('<p class="text-danger">Hubo un error al cargar los productos.</p>');
            }
        });
    }

    // Función para crear y enviar el formulario encriptado
    function submitEncryptedForm(productId, productName, productPrice) {
        $.ajax({
            url: '/encrypt-data',  // Endpoint PHP para cifrar los datos
            method: 'POST',
            data: {
                id: productId,
                name: productName,
                price: productPrice,
            },
            success: function (encryptedData) {
                // Enviar los datos cifrados al servidor sin redireccionar
                $.ajax({
                    url: '/agregar-al-carrito',  // Endpoint PHP para agregar el producto al carrito
                    method: 'POST',
                    data: {
                        encrypted_data: encryptedData
                    },
                    success: function (response) {
                        // Mostrar mensaje de éxito
                        Swal.fire({
                            position: "top-end",
                            toast: true,
                            title: "Exito",
                            text: response.message,
                            icon: "success",
                            showConfirmButton: false,
                            timer: 1500
                        });
                        // Aquí puedes actualizar el carrito dinámicamente si lo deseas
                    },
                    error: function () {
                        Swal.fire({
                            position: "top-end",
                            toast: true,
                            title: "Error",
                            text: "Hubo un problema al agregar el producto al carrito.",
                            icon: "error",
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                });
            },
            error: function () {
                Swal.fire({
                    position: "top-end",
                    toast: true,
                    title: "Error",
                    text: "Error al cifrar los datos.",
                    icon: "error",
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        });
    }

    // Cargar productos para la pestaña activa al cargar la página
    var initialCategory = 'all';
    loadProducts(initialCategory);

    // Manejar el evento de cambio de pestaña
    $('button[data-bs-toggle="pill"]').on('shown.bs.tab', function (e) {
        var category = $(e.target).data('category'); // Obtener el IdCategoria de la pestaña seleccionada

        // Mostrar el contenedor correspondiente y ocultar los demás
        $('.tab-pane').removeClass('show active'); // Ocultar todos
        $('#pills-' + category).addClass('show active'); // Mostrar el contenedor de la categoría seleccionada

        loadProducts(category); // Cargar los productos de la categoría seleccionada
    });
});
