//FOR CURRENT PATH

// Espera a que el DOM esté completamente cargado
document.addEventListener('DOMContentLoaded', function () {
    // Obtener la URL actual sin parámetros de consulta ni fragmentos
    const currentPath = window.location.pathname;
    //console.log(currentPath);

    // Seleccionar todos los enlaces de navegación
    const navLinks = document.querySelectorAll('.navbar a');

    // Recorrer los enlaces y agregar la clase 'active' al que coincida con la ruta actual
    navLinks.forEach(link => {
        const href = link.getAttribute('href');

        // Si el href está contenido en la ruta actual, agregar la clase 'active'
        if (currentPath.includes(href) && href !== '') {
            link.classList.add('active');
        }

        // Manejar caso especial para la raíz del sitio ('/')
        if (currentPath === '/' && href === '../') {
            link.classList.add('active');
        }
    });
});

