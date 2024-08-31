// Ejecución cuando el DOM esté completamente cargado
document.addEventListener('DOMContentLoaded', function () {
    handleCurrentPath();
    handleContactForm();
});

// Function para manejar la navegación activa
function handleCurrentPath() {
    const currentPath = window.location.pathname;
    const navLinks = document.querySelectorAll('.navbar a');

    navLinks.forEach(link => {
        const href = link.getAttribute('href');

        if (currentPath.includes(href) && href !== '') {
            link.classList.add('active');
        }

        // Caso especial para la raíz del sitio ('/')
        if (currentPath === '/' && href === '../') {
            link.classList.add('active');
        }
    });
}

// Function para manejar el loader
function handleLoader() {
    window.addEventListener("load", () => {
        const loaderContainer = document.querySelector(".loader-container");

        loaderContainer.classList.add("loader--hidden");

        loaderContainer.addEventListener("transitionend", () => {
            document.body.removeChild(loaderContainer);
        });
    });
}

// Function para manejar el envío del formulario de contacto
function handleContactForm() {
    const form = document.querySelector(".Contactform");
    if (!form) return; // Verificar si existe el formulario en la página

    form.addEventListener("submit", async function handleSubmit(event) {
        event.preventDefault();
        const formData = new FormData(event.target);
        try {
            const response = await fetch(event.target.action, {
                method: event.target.method,
                body: formData,
                headers: {
                    'Accept': 'application/json'
                }
            });

            if (response.ok) {
                event.target.reset();
                Swal.fire({
                    title: "¡Buen trabajo!",
                    text: "Tu mensaje ha sido enviado.",
                    icon: "success"
                });
            } else {
                Swal.fire({
                    title: "Oops...",
                    text: "Hubo un problema al enviar tu mensaje. Intenta nuevamente.",
                    icon: "error"
                });
            }
        } catch (error) {
            Swal.fire({
                title: "Oops...",
                text: "Hubo un problema al enviar tu mensaje. Intenta nuevamente.",
                icon: "error"
            });
        }
    });
}

// Ejecuta el loader
handleLoader();
