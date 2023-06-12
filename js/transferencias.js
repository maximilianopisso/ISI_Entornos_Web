console.log("SE CARGA SCRIPT TRANSFERENCIAS.JS");

$("#formTransferencias").submit(function (e) {
    e.preventDefault(); // Evita que el formulario se envíe automáticamente

    // Obtén los valores de los campos de entrada
    var cuentaOrigen = $("#cuentaOrigen").val();
    var cuentaDestino = $("#cuentaDestino").val();
    var importe = $("#importe").val();

    //Expresion regular para el importe
    var importeRegex = /^\d+(\.\d{0,2})?$/;

    // Validaciones para input email
    if (cuentaOrigen.trim() === "seleccionar") {
        showAlert("Debe ingresar una cuenta origen.", "warning");
        return;
    }

    if (cuentaDestino.trim() === "seleccionar") {
        showAlert("Debe ingresar una cuenta destino.", "warning");
        return;
    }

    if (importeRegex.exec(importe) == null) {
        showAlert("El importe deber ser numérico y el formato válido es xxx.xx", "warning");
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