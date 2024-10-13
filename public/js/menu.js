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
                                    <button class="btn btn-menu d-block w-100"><i class="bi bi-cart-plus fs-4"></i></button>
                                </div>
                            </div>
                        </div>
                    `;
                    //console.log('Insertando producto en contenedor: ', containerId);
                    $(containerId).append(productHtml);
                });
            },
            error: function (xhr, status, error) {
                //console.error('Error al obtener los productos:', error);
                $(containerId).append('<p class="text-danger">Hubo un error al cargar los productos.</p>');
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
