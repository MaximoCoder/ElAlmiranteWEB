// Ejecución cuando el DOM esté completamente cargado
document.addEventListener('DOMContentLoaded', function () {
    handleCurrentPath();
    // Ejecuta el loader
    handleLoader();

});

// Function para manejar la navegación activa
function handleCurrentPath() {
    const currentPath = window.location.pathname;
    const navLinks = document.querySelectorAll('.navbar a');

    navLinks.forEach(link => {
        try {
            // Valida si el link.href es válido antes de construir el objeto URL
            const href = new URL(link.href).pathname; // Normaliza el href a un pathname completo

            // Elimina la clase 'active' de todos los enlaces
            link.classList.remove('active');

            // Compara el href con el currentPath
            if (currentPath === href || (currentPath.startsWith(href) && href !== '/')) {
                link.classList.add('active');
            }

            // Caso especial para la raíz de la página web ('/')
            if (currentPath === '/' && href === '/') {
                link.classList.add('active');
            }

        } catch (error) {
            // Manejar el caso de una URL inválida
            console.error(`URL inválida en el enlace: ${link.href}`, error);
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

// Function para manejar el registro de usuario usando jQuery/Ajax
function handleRegisterForm() {
    const registerForm = document.getElementById("register-form");
    if (!registerForm) return; // Verificar si existe el formulario de registro en la página

    registerForm.addEventListener("submit", function (event) {
        event.preventDefault();

        const nombre = document.getElementById('Nombre').value;
        const correo = document.getElementById('Correo').value;
        const password = document.getElementById('Password').value;
        const confirmPassword = document.getElementById('confirm_password').value;

        $.ajax({
            url: '/auth/register',  
            method: 'POST',
            contentType: 'application/json',
            dataType: 'json',
            data: JSON.stringify({
                Nombre: nombre,
                Correo: correo,
                Password: password,
                confirm_password: confirmPassword
            }),
            success: function (response) {
                if (response.status === 'success') {
                    registerForm.reset();
                    window.location.href = '../auth/login';  // Redirecciona después del registro exitoso
                } else {
                    // Muestra el mensaje de error que proviene del servidor
                    Swal.fire({
                        title: "Oops...",
                        text: response.message || "Hubo un problema al registrar.",
                        icon: "error"
                    });
                }
            },
            error: function (xhr, status, error) {
                //console.log("Respuesta completa del servidor: ", xhr.responseText); // Mostrar la respuesta en la consola
                Swal.fire({
                    title: "Oops...",
                    text: "Error en la solicitud: " + error,
                    icon: "error"
                });
            }
        });
    });
}


// Function para manejar el login de usuario usando jQuery/Ajax
function handleLoginForm() {
    const loginForm = document.getElementById("login-form");
    if (!loginForm) return; // Verificar si existe el formulario de login en la página

    loginForm.addEventListener("submit", function (event) {
        event.preventDefault();
        const correo = document.getElementById('Correo').value;
        const password = document.getElementById('Password').value;

        $.ajax({
            url: '/auth/login',  
            method: 'POST',
            contentType: 'application/json',
            dataType: 'json',
            data: JSON.stringify({
                Correo: correo,
                Password: password
            }),
            success: function (response) {
                if (response.status === 'success') {
                    loginForm.reset();
                    //Redirigir segun el rol
                    //console.log(response.rol);
                    if (response.rol === 'admin') {
                        window.location.href = '/admin';
                    } else if (response.rol === 'User') {
                        window.location.href = '../';
                    }
                } else {
                    // Muestra el mensaje de error que proviene del servidor
                    Swal.fire({
                        title: "Oops...",
                        text: response.message || "Hubo un problema al intentar inciar sesión.",
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
}

// Function para manejar el forgor password page = Enviar correo de recuperación de usuario usando jQuery/Ajax
function handleForgotForm() {
    const forgotForm = document.getElementById("forgot-form");
    if (!forgotForm) return; // Verificar si existe el formulario de login en la página

    forgotForm.addEventListener("submit", function (event) {
        event.preventDefault();
        const correo = document.getElementById('Correo').value;
       
        $.ajax({
            url: '/auth/forgot-Password',  
            method: 'POST',
            contentType: 'application/json',
            dataType: 'json',
            data: JSON.stringify({
                Correo: correo,
            }),
            success: function (response) {
                if (response.status === 'success') {
                    forgotForm.reset();
                    //Redirigir si se envio el correo
                    window.location.href = '../auth/verify-Code';
                   
                } else {
                    // Muestra el mensaje de error que proviene del servidor
                    Swal.fire({
                        title: "Oops...",
                        text: response.message || "Hubo un problema al intentar enviar el correo.",
                        icon: "error"
                    });
                }
            },
            error: function (xhr, status, error) {
                //console.log("Respuesta completa del servidor: ", xhr.responseText); // Mostrar la respuesta en la consola
                Swal.fire({
                    title: "Oops...",
                    text: "Error en la solicitud: " + error,
                    icon: "error"
                });
            }
        });
    });
}

// Function para manejar el verify code enviado al correo usando jQuery/Ajax
function handleVerifyForm() {
    const verifyForm = document.getElementById("verify-form");
    if (!verifyForm) return; // Verificar si existe el formulario de login en la página

    verifyForm.addEventListener("submit", function (event) {
        event.preventDefault();
        const Code = document.getElementById('Code').value;
       
        $.ajax({
            url: '/auth/verify-Code',  
            method: 'POST',
            contentType: 'application/json',
            dataType: 'json',
            data: JSON.stringify({
                Code: Code,
            }),
            success: function (response) {
                if (response.status === 'success') {
                    verifyForm.reset();
                    //Redirigir si el codigo es correcto
                    window.location.href = '../auth/change-Password';
                   
                } else {
                    // Muestra el mensaje de error que proviene del servidor
                    Swal.fire({
                        title: "Oops...",
                        text: response.message || "Hubo un problema al verificar el codigo.",
                        icon: "error"
                    });
                }
            },
            error: function (xhr, status, error) {
                //console.log("Respuesta completa del servidor: ", xhr.responseText); // Mostrar la respuesta en la consola
                Swal.fire({
                    title: "Oops...",
                    text: "Error en la solicitud: " + error,
                    icon: "error"
                });
            }
        });
    });
}

// Function para manejar el verify code enviado al correo usando jQuery/Ajax
function handleChangePassword() {
    const ChangePasswordForm = document.getElementById("changePassword-form");
    if (!ChangePasswordForm) return; // Verificar si existe el formulario de login en la página

    ChangePasswordForm.addEventListener("submit", function (event) {
        event.preventDefault();
        const newPassword = document.getElementById('newPassword').value;
        const confirmPassword = document.getElementById('confirmPassword').value;
        $.ajax({
            url: '/auth/change-Password',  
            method: 'POST',
            contentType: 'application/json',
            dataType: 'json',
            data: JSON.stringify({
                newPassword: newPassword,
                confirmPassword: confirmPassword,
            }),
            success: function (response) {
                if (response.status === 'success') {
                    ChangePasswordForm.reset();
                    //Redirigir si el codigo es correcto
                    window.location.href = '../auth/login';
                   
                } else {
                    // Muestra el mensaje de error que proviene del servidor
                    Swal.fire({
                        title: "Oops...",
                        text: response.message || "Hubo un problema al intentar cambiar el password.",
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
}