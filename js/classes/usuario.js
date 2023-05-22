const NUMINTENTOS = 3;
class Usuario {

    constructor(nombre, apellido, email, password, contacto, sexo, movimientos) {
        this.nombre = nombre;
        this.apellido = apellido;
        this.email = email;
        this.password = password;
        this.contacto = contacto;
        this.sexo = sexo;
        // Registros de movimientos
        this.movimientos = movimientos;
        // Control Login
        this.nroIntentos = NUMINTENTOS;
        this.habilitado = true;
    }

    /**
     * Funcion para validar los datos ingresados de login 
     * @param {*} email : parametro correspondiente al usuario
     * @param {*} password : parametro correspondiente a la contraseña
     * @returns 
     */
    validarLogin(email, password) {
        let respuesta = [false, 0]
        // Verifica condicion de nro de intentos
        if (this.nroIntentos > 0) {
            // Evaua condicion para permitir el login del usuario
            if ((this.email == email) && (this.password == password)) {
                respuesta = [true, 0];
                //resetea cantidad de intentos 
                this.resetNroIntentos();
                console.log("Al usuario: " + email + " se le restauraron sus " + (this.nroIntentos) + " intentos restantes");
            } else {
                // Evalua si el mail coincide, para determinar si hay que restar intentos
                if ((this.email == email)) {
                    this.nroIntentos -= 1;
                    console.log("El usuario: " + email + " tiene " + (this.nroIntentos) + " intentos restantes");
                    // Error de contraseña
                    respuesta = [true, 1]
                } else {
                    // Error de usuario o contraseña invalidos
                    respuesta = [false, 2];
                }
            }
        } else {
            if (this.email == email) {
                // Usuario bloqueado
                respuesta = [true, 3]
            } else {
                // Usuario bloqueado pero no el buscado
                respuesta = [false, 2];
            }
        }
        return respuesta;
    }

    /**
     * Agrega un nuevo movimiento al array de movimientos del usuario
     * @param {*} lote numero de operacion gral
     * @param {*} tipoOperacion tipo de operacion (1 para deposito, 2 para transferencia)
     * @param {*} importe importe a registrar en el movimiento
     * @param {*} cuentaDestino Cuenta con la que se realiza la operacion
     */
    registrarMovimiento(fecha, puntaje, descripcion, cantDias) {
        //definir descripcion del movimiento
        let lote = JSON.parse(localStorage.getItem(`idLote`));
        //console.log(lote);
        let numUltimoMov = this.movimientos.length + 1;
        //fecha elaboracion
        let fechaElaboracion = formatearFecha(fecha, 0, `/`);
        let fechaVencimiento = formatearFecha(fecha, cantDias, `/`);
        let movEsterilizacion = new Movimiento(numUltimoMov, fechaElaboracion, lote, descripcion, puntaje, cantDias, fechaVencimiento);
        // console.log(movEsterilizacion);
        this.movimientos.push(movEsterilizacion);
        //console.log(this.movimientos)
        // SUMO 1 AL LOTE PARA EL PROXIMO LOTE Y SE GUARDA EN EL LS
        lote += 1;
        localStorage.setItem(`idLote`, lote);
    }

    mostrarResultado() {
        let acumulador = ``;
        let ultimoRegistro = this.movimientos.length - 1
        acumulador += `<tr>
                    <td>${this.movimientos[ultimoRegistro].puntaje} pts</td>
                    <td>${this.movimientos[ultimoRegistro].diasEsteriles} días</td>
                    <td>${this.movimientos[ultimoRegistro].vencimiento}</td>
                </tr>`
        document.getElementById(`detalleResultadoTabla`).innerHTML = acumulador;
    }

    /**
     * Muesta Todos los movimientos que ha realizado el usuario
     */
    mostrarMovimientos() {
        let acumulador = ``;
        for (let i = 0; i < this.movimientos.length; i++) {
            acumulador += `<tr>
                <td>${i + 1}</td>
                <td>${this.movimientos[i].fecha}</td>
                <td>${this.movimientos[i].lote}</td>
                <td>${this.movimientos[i].proceso}</td>
                <td>${this.movimientos[i].puntaje} pts</td>
                <td>${this.movimientos[i].diasEsteriles} días</td>
                <td>${this.movimientos[i].vencimiento}</td>
            </tr>`
        }
        document.getElementById(`detalleMovTabla`).innerHTML = acumulador;
    }

    /**
     * Funcion que resetea el valor de numeros de intentos permitidos por usuario para realizar el login
    */
    resetNroIntentos() {
        this.nroIntentos = NUMINTENTOS;
    }
}


