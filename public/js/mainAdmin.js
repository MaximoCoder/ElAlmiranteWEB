// AQUI IRAN FUNCIONES PRINCIPALES DE ADMINISTRADOR COMO: Agregar platillos, agregar categorias, etc.

// Function para manejar el registro de un platillo jQuery/Ajax
function addPlatilloForm() {
    const platilloForm = document.getElementById("platillo-form");
    let isSubmitting = false; // Indicador de estado para prevención de envíos multiples

    if (!platilloForm) return; // Verificar si existe el formulario de registro en la página

    platilloForm.addEventListener("submit", function (event) {
        event.preventDefault();

        if (isSubmitting) return; // Si ya se está enviando, no hacer nada
        isSubmitting = true; // Marcar como en proceso de envío

        // Crear FormData para enviar los datos del formulario y la imagen
        const formData = new FormData(platilloForm);
        $.ajax({
            url: '/admin/Agregar_Productos',
            method: 'POST',
            processData: false,
            contentType: false,
            data: formData,
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
                isSubmitting = false; // Restablecer estado
            },
            error: function (xhr, status, error) {
                Swal.fire({
                    title: "Oops...",
                    text: "Error en la solicitud: " + error,
                    icon: "error"
                });
                isSubmitting = false; // Restablecer estado
            }
        });
    });
}