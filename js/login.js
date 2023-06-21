console.log("SE CARGA SCRIPT LOGIN2.JS");

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
        showAlert("Debe ingresar un email.");
        return;
    }

    if (emailRegex.exec(email) == null) {
        showAlert("El email ingresado no posse un formato válido.");
        return;
    }

    // Validaciones para input password
    if (password.trim() === "") {
        showAlert("Debe ingresar una contraseña.");
        return;
    }

    // Validación de longitud de contraseña
    if (passwordRegex.exec(password) == null) {
        showAlert("La contraseña debe tener entre 8 y 15 caracteres alfanuméricos.");
        return;
    }
    // Si todas las validaciones son exitosas, enviar el formulario
    this.submit();
});

function showAlert(message) {
    var container = $("#msjError");
    container.empty(); // Limpia el contenido anterior
    container.append(`<div id="alerta" class="alert alert-warning" role="alert" style="height:25px; max-height: 25px; display: flex; align-items: center;justify-content: center; font-weight:600">${message}</div>`);
    // Hace que la alerta desaparezca en el tiempo estipulado
    setTimeout(function () {
        container.empty();
    }, 2000);
}