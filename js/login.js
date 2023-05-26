var usuarios = [];

if (localStorage.listaUsuarios != null) {
    usuarios = recrearBD(`listaUsuarios`);
    console.log("CARGA LOCALSTORE - LISTADO USUARIOS");
    console.log(usuarios); //LO MUESTRO PARA QUE PUEDAN USAR LAS CREDENCIALES EN EL LOGIN
}
else {
    console.log("CARGA LOCAL POR CODIGO");
    usuarios = loadInitialData();             //ESTE PASO PODRIA EVITARSE, PERO ES PARA USAR UN JUEGO DE USUARIOS DE PRUEBA CONOCIDOS PORQUE LO DE API SON ALEATORIOS
    console.log(usuarios);
    console.log("SE SUMAN USUARIOS POR API");
    concatenarUsuariosAPI();
}

$("#formularioLogin").submit(function (e) {
    e.preventDefault();
    let email = $("#email").val();
    let pass = $("#password").val();
    if (validainputs(email, pass)) {
        validarUsuario(email, pass);
    }
})

/**
  * Funcion para que pueda sumarse al listado local de usuarios los usuarios obtenidos por la API
  */
async function concatenarUsuariosAPI() {
    try {
        const data = await usuariosApi();
        usuarios = usuarios.concat(convertirUsuarios());
    }
    catch (err) {
        alert("NO SE PUDO CARGAR DATOS POR API");
    }
    localStorage.setItem(`listaUsuarios`, JSON.stringify(usuarios));
    console.log(usuarios); //LO MUESTRO PARA QUE PUEDAN USAR LAS CREDENCIALES EN EL LOGIN
}

/**
 * FUNCION PARA VALIDAR DATOS INGRESADOS EN LOGIN
 * @param {*} email : PARAMETRO PARA EL EMAIL
 * @param {*} password: PARAMETRO PARA LA CONTRASEÑA
 */
function validarUsuario(email, password) {
    let respuesta = [];
    let encontrado = false;
    let indice_error = ""

    for (let i = 0; i < usuarios.length; i++) {
        //LLama a la funcion de validacion del propio usuario para chequear su usuario y contraseña con el enviados a traves del metodo.
        respuesta = usuarios[i].validarLogin(email, password)
        if (respuesta[0] == true && respuesta[1] == 0) {
            encontrado = true;
            // La validacion resetea nro intentos, tengo que guardarla en el localStore
            localStorage.setItem(`listaUsuarios`, JSON.stringify(usuarios))
            //Guardo informacion del usuario en el local para levantarlo en el otro js.
            localStorage.setItem("userID", i);
            break;
        } else {
            if (respuesta[0] == true && ((respuesta[1] == 1) || (respuesta[1] == 3))) {
                // La comprobacion de mail resta nro intentos, tengo que guardarla en el localStore
                localStorage.setItem(`listaUsuarios`, JSON.stringify(usuarios))
                encontrado = false;
                // Esto se hace para mostrar intento fallido por usuario correcto y no contraseña
                indice_error = i
                break;
            }
        }
    }
    if (encontrado) {
        location.href = "./home.php";
    } else {
        msjErrorLogin(respuesta[1], indice_error);
    }
}

function validainputs(email, password) {
    regExpEmail = /\S+@\S+\.\S+/;
    try {
        console.log("email: " + email + "pass: " + password);
        if (email == "" && password == "") {
            throw Error("4");
        }
        if (email == "") {
            throw Error("5");
        }
        if (password == "") {
            throw Error("6");
        }
        if (regExpEmail.exec(email) == null) {
            throw Error("7")
        }
        return true;
    } catch (error) {
        console.log(error);
        txtError = error.toString();
        msjErrorLogin(error.toString()[7]);
        return false;
    }

};

function msjErrorLogin(codigoError, indice_error) {
    $("#formularioLogin")[0].reset();
    console.log(codigoError.toString());
    switch (codigoError.toString()) {
        case "1":
            if (usuarios[indice_error].nroIntentos == 0) {
                $("#msjerror").html(`La contraseña es incorrecta. Su usuario fue bloqueado`)
            } else {
                $("#msjerror").html(`La contraseña es incorrecta. Nro Intentos: ${usuarios[indice_error].nroIntentos}`)
            }
            break;
        case "2": $("#msjerror").html(`El usuario o la contraseña son incorrectos`);
            break;
        case "3": $("#msjerror").html(`Tu usuario ha sido BLOQUEADO`);
            break;
        case "3": $("#msjerror").html(`Tu usuario ha sido BLOQUEADO`);
            break;
        case "4": $("#msjerror").html(`Los campos email y password son requeridos`);
            break;
        case "5": $("#msjerror").html(`El mail es un campo requerido`);
            break;
        case "6": $("#msjerror").html(`El password es un campo requerido`);
            break;
        case "7": $("#msjerror").html(`El email no posse un formato válido`);
            break;
        default:
            $("#msjerror").html(`Error desconocido. Contáctese con el Administador`);
            break;
    }
    $("#msjerror").show(50)
        .delay(5000)
        .hide(100)
}