<!--CONTENT -->
<div class="form-area" >
    <div >
        <div class="row single-form g-0">
            <div class="col-sm-12 col-lg-6">
                <div class="left">
                    <h2><span>Contáctanos,</span><br>Nos encantaría escuchar tu opinión.</h2>
                    <p class="mt-4 text-white"><i class="bi bi-telephone-fill"> +52 81 8277 7311</i></p>
                </div>
            </div>
            <div class="col-sm-12 col-lg-6">
                <div class="right">
                    <i class="fa fa-caret-left"></i>
                    <form action="https://formspree.io/f/xkndaywz" method="POST">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Tu nombre</label>
                            <input type="text" class="form-control" name="nombre" aria-describedby="emailHelp" required>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Tu Correo electronico</label>
                            <input type="email" class="form-control" name="email" aria-describedby="emailHelp" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tu opinion</label>
                            <textarea class="form-control" name="opinion" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-outline-dark">Enviar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // SCRIPT PARA MANEJAR EL ENVIO DEL FORMULARIO
    const form = document.querySelector("form");
    form.addEventListener("submit", handleSubmit);

    async function handleSubmit(event) {
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
    }
</script>