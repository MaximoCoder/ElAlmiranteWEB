document.addEventListener('DOMContentLoaded', () => {
    const allSideMenu = document.querySelectorAll('#sidebar .side-menu.top li a');
    
    // Obtener la ruta actual y limpiarla
    let currentPath = window.location.pathname;
    currentPath = currentPath.endsWith('/') ? currentPath.slice(0, -1) : currentPath; // Eliminar barra final si existe

    allSideMenu.forEach(item => {
        const href = item.getAttribute('href');
        if (!href) return; // Saltar si no hay atributo href

        // Normalizar la ruta del enlace quitando los ".."
        const cleanHref = new URL(href, window.location.origin).pathname;
        
        // Comprobar si la ruta actual coincide con el href del enlace
        if (currentPath === cleanHref || currentPath.endsWith(cleanHref)) {
            // Quitar cualquier clase "active" previa y asignar al actual
            allSideMenu.forEach(i => {
                i.parentElement.classList.remove('active');
            });
            item.parentElement.classList.add('active');
        }
    });

    // Agregar eventos click para navegación
    allSideMenu.forEach(item => {
        item.addEventListener('click', function () {
            allSideMenu.forEach(i => {
                i.parentElement.classList.remove('active');
            });
            this.parentElement.classList.add('active');
        });
    });
});

// TOGGLE SIDEBAR
const menuBar = document.querySelector('#content nav .bx.bx-menu');
const sidebar = document.getElementById('sidebar');

menuBar.addEventListener('click', function () {
	sidebar.classList.toggle('hide');
})



const searchButton = document.querySelector('#content nav form .form-input button');
const searchButtonIcon = document.querySelector('#content nav form .form-input button .bx');
const searchForm = document.querySelector('#content nav form');

searchButton.addEventListener('click', function (e) {
	if(window.innerWidth < 576) {
		e.preventDefault();
		searchForm.classList.toggle('show');
		if(searchForm.classList.contains('show')) {
			searchButtonIcon.classList.replace('bx-search', 'bx-x');
		} else {
			searchButtonIcon.classList.replace('bx-x', 'bx-search');
		}
	}
})





if(window.innerWidth < 768) {
	sidebar.classList.add('hide');
} else if(window.innerWidth > 576) {
	searchButtonIcon.classList.replace('bx-x', 'bx-search');
	searchForm.classList.remove('show');
}


window.addEventListener('resize', function () {
	if(this.innerWidth > 576) {
		searchButtonIcon.classList.replace('bx-x', 'bx-search');
		searchForm.classList.remove('show');
	}
})



const switchMode = document.getElementById('switch-mode');

switchMode.addEventListener('change', function () {
	if(this.checked) {
		document.body.classList.add('dark');
	} else {
		document.body.classList.remove('dark');
	}
})