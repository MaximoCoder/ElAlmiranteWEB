document.addEventListener('DOMContentLoaded', function() {
    const hamburger = document.querySelector("#toggle-btn");
    const sidebar = document.querySelector("#sidebar");

    if (hamburger && sidebar) { // Asegurarse de que los elementos existan
        hamburger.addEventListener("click", function() {
            sidebar.classList.toggle("expand");
        });
    }
});
