// AQUI IRAN FUNCIONES PRINCIPALES DE ADMINISTRADOR COMO: Agregar platillos, agregar categorias, etc.

// Function para manejar el registro de un platillo jQuery/Ajax
function addPlatilloForm() {
    const platilloForm = document.getElementById("platillo-form");
    if (!platilloForm) return; // Verificar si existe el formulario de registro en la página

    platilloForm.addEventListener("submit", function (event) {
        event.preventDefault();

        // Crear FormData para enviar los datos del formulario y la imagen
        const formData = new FormData(platilloForm);
        $.ajax({
            url: '/admin/Agregar_Productos',
            method: 'POST',
            processData: false,
            contentType: false,
            data: formData, // Usamos formData en lugar de JSON
            success: function (response) {
                if (response.status === 'success') {
                    platilloForm.reset();
                    previewImagen.src = "";
                    previewImagen.style.display = 'none';
                    eliminarImagenBtn.style.display = 'none';
                    Swal.fire({
                        title: "Éxito",
                        text: response.message,
                        icon: "success"
                    });
                } else {
                    // Muestra el mensaje de error que proviene del servidor
                    Swal.fire({
                        title: "Oops...",
                        text: response.message || "Hubo un problema al agregar el platillo.",
                        icon: "error"
                    });
                }
            },
            error: function (xhr, status, error) {
                console.log("Respuesta completa del servidor: ", xhr.responseText); // Mostrar la respuesta en la consola
                Swal.fire({
                    title: "Oops...",
                    text: "Error en la solicitud: " + error,
                    icon: "error"
                });
            }
        });
    });
    $(document).ready(function() {
        // Llama a la función para cargar los platillos
        loadPlatillos();
    
        // Función para cargar platillos
        function loadPlatillos() {
            $.ajax({
                url: '/admin/obtenerPlatillos.php',
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    var tbody = $('#table-platillos tbody');
                    tbody.empty(); // Limpiar el tbody antes de agregar nuevos datos
    
                    $.each(data, function(index, platillo) {
                        tbody.append(`
                            <tr>
                                <td>${platillo.IdPlatillo}</td>
                                <td>${platillo.NombrePlatillo}</td>
                                <td>${platillo.DescripciónPlatillo}</td>
                                <td>${platillo.PrecioPlatillo}</td>
                                <td>${platillo.Disponibilidad}</td>
                                <td><img src="${platillo.Imagen}" alt="${platillo.NombrePlatillo}" width="50" height="50"></td>
                                <td>${platillo.FechaRegistro}</td>
                            </tr>
                        `);
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error al cargar los platillos:', error);
                }
            });
        }
    
    });
    
// Función para eliminar una categoría
function eliminarCategoria(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "No podrás revertir esta acción",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',  // Color del botón de confirmación
        cancelButtonColor: '#d33',  // Color del botón de cancelación
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/admin/categorias/eliminar?id=${id}`, {
                method: 'DELETE',
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: "Eliminado",
                        text: "La categoría ha sido eliminada exitosamente.",
                        icon: "success",
                        confirmButtonColor: '#3085d6'
                    }).then(() => {
                        location.reload(); // Recargar la página para ver los cambios
                    });
                } else {
                    Swal.fire({
                        title: "Oops...",
                        text: "Error al eliminar la categoría: " + data.error,
                        icon: "error"
                    });
                }
            })
            .catch(error => {
                console.error("Error:", error);
                Swal.fire({
                    title: "Oops...",
                    text: "Se produjo un error: " + error.message,
                    icon: "error"
                });
            });
        }
    });
}

// Función para abrir el modal de edición con los datos de la categoría seleccionada
function abrirModalEditar(id, nombre) {
    document.getElementById('categoriaId').value = id;
    document.getElementById('nombreCategoriaEditar').value = nombre;
}

// Función para editar una categoría
function editarCategoria() {
    const form = document.getElementById('form-editar-categoria');
    const formData = new FormData(form);

    fetch('/categorias/editar', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                title: "Éxito",
                text: "Categoría modificada exitosamente.",
                icon: "success",
                confirmButtonColor: '#3085d6'
            }).then(() => {
                location.reload(); // Recargar la página para ver los cambios
            });
        } else {
            Swal.fire({
                title: "Oops...",
                text: "Error al modificar la categoría: " + data.error,
                icon: "error"
            });
        }
    })
    .catch(error => {
        console.error("Error:", error);
        Swal.fire({
            title: "Oops...",
            text: "Se produjo un error: " + error.message,
            icon: "error"
        });
    });
}

}

