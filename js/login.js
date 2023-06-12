console.log("SE CARGA SCRIPT LOGIN.JS");

$("#formularioLogin").submit(function (e) {
    e.preventDefault(); // Evita que el formulario se envíe automáticamente

    // Obtén los valores de los campos de entrada
    var email = $("#email").val();
    var password = $("#password").val();

    console.log(email);
    console.log(password);
    var emailRegex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    var passwordRegex = /^[a-zA-Z0-9]{8,15}$/;

    // Validaciones para input email
    if (email.trim() === "") {
        showAlert("Debe ingresar un email.", "warning");
        return;
    }

    if (emailRegex.exec(email) == null) {
        showAlert("El email ingresado no posse un formato válido.", "warning");
        return;
    }

    // Validaciones para input password
    if (password.trim() === "") {
        showAlert("Debe ingresar una contraseña.", "warning");
        return;
    }

    // Validación de longitud de contraseña
    if (passwordRegex.exec(password) == null) {
        showAlert("La contraseña debe tener entre 8 y 15 caracteres alfanuméricos.", "warning");
        return;
    }
    // Si todas las validaciones son exitosas, enviar el formulario
    this.submit();
});

function showAlert(message, type) {
    // Crea el elemento de alerta de Bootstrap
    var alertDiv = $("<div>").addClass("alert alert-" + type)
        .attr("role", "alert")
        .attr("id", "alerta")
        .css({
            // "height": "40px",
            "max-height": "40px",
            "font-weight": "600",
            "display": "flex",
            "align-items": "center",
            "justify-content": "center",
        })
        .text(message);

    // Agrega la alerta al contenedor específico
    var container = $("#msjError");
    container.empty(); // Limpia el contenido anterior
    container.append(alertDiv);

    // Hace que la alerta desaparezca después de 4 segundos
    setTimeout(function () {
        container.empty();
    }, 4000);
}