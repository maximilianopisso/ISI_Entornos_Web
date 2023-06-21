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
        showAlert("Debe ingresar una cuenta origen.");
        return;
    }

    if (cuentaDestino.trim() === "seleccionar") {
        showAlert("Debe ingresar una cuenta destino.");
        return;
    }

    if (importeRegex.exec(importe) == null) {
        showAlert("El importe deber ser numérico y el formato válido es xxx.xx");
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