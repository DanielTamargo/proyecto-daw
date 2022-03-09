/// <reference path="./login.js" />

/**
 * Implementamos la interfaz JQuery para el método notify, ya que la librería notify.js añade un método
 * capaz de mostrar notificaciones y TS no lo reconoce, añadiendo esta interfaz eliminamos el error
 */
interface JQuery {
    notify(name: string, options: object): void;
    notify(name: string, type: string, options: object): void;
}


/**
 * Definimos en una clase los campos que esperamos recibir en la respuesta de la api
 */
class PeticionAPIUsuarioComprobarCampo {
    ok: boolean;
    mensaje: string;
    valor_unico: boolean;

    constructor(ok: boolean, mensaje: string, valor_unico: boolean) {
        this.ok = ok;
        this.mensaje = mensaje;
        this.valor_unico = valor_unico;
    }
}


// Document ready
$.when( $.ready ).then(function() {
    // Comprobar si se ha cargado la ventana con la intención de registrar
    if ($("#cargar-registro").val() === "true") {
        // Si es usuario administrador, NO podrá deslizar al login
        if ($("#nuevo-administrador").val())
            cargarSoloRegistro();
        else 
            $("#form2").trigger('click');
    }
});


// Longitud de contraseña deseada
var longitud_deseada_contrasenya: number = 8;

// Variables error que controlan si se hace la animación o no
var error_dni: boolean = false;
var error_password_confirmar: boolean = false;
var error_password_longitud: boolean = false;
var error_password_caracteres: boolean = false;
var error_email_unico: boolean = false;
var error_username_unico: boolean = false;


/**
 * Valida el DNI introducido (expresión regular y comprobación dni válida)
 * @param {string} dni DNI a comprobar
 */
function validarDNI(dni: string): boolean {
    // Comprobamos que hemos recibido un string
    if (typeof dni != "string") {
        // Error: ¡No es un string!
        return false;
    }

    dni = dni.toUpperCase();
    let regex_dni: RegExp = /^\d{8}[a-zA-Z]$/;

    // Comprobamos la expresión regular
    if (!regex_dni.test(dni)) {
        // Error: ¡Formato no válido!
        return false;
    }

    // Comprobamos el valor de la letra del DNI
    let lista_letras: string = 'TRWAGMYFPDXBNJZSQVHLCKET';
    let numero: number = Number(dni.substring(0, dni.length - 1));
    let letra_dni: string = dni.substring(dni.length - 1);
    if (letra_dni != lista_letras.charAt(numero % 23)) {
        // Error: ¡DNI no válido!
        return false;
    }

    // ¡DNI Válido!
    return true;
}

/**
 * Comprueba el DNI, si no es válido lo notifica y bloquea el botón submit,
 * si es válido desbloquea el botón submit si ha sido bloqueado
 */
function comprobarDNI(): void {
    let input_dni: JQuery<HTMLElement> = $("#dni");
    let dni_valido: boolean = validarDNI(String(input_dni.val()));
    if (dni_valido) {
        error_dni = false;
        rehabilitarBoton();
        input_dni.notify(``, { autoHideDelay: 0, showDuration: 0 }); // <- para ocultar posible notificación previa
    } else {
        if (!error_dni) {
            error_dni = true;
            $("#registro-submit").attr('disabled', "true");
            input_dni.notify("DNI no válido.", { autoHide: false, clickToHide: false });
        }
    }
}

/**
 * Verifica que las contraseñas introducidas coinciden.
 */
function cotejarContrasenyas(): boolean {
    let elm_password_confirmation: JQuery<HTMLElement> = $("#password-confirm");

    let password: string = String($("#password").val()).trim();
    let password_confirmation: string = String(elm_password_confirmation.val()).trim()

    if (password_confirmation.length > 0 && password !== password_confirmation) {
        if (!error_password_confirmar) {
            error_password_confirmar = true;
            $("#registro-submit").attr('disabled', "true");
            elm_password_confirmation.notify("Las contraseñas no coinciden", { autoHide: false, clickToHide: false });
        }

        return false;
    } else {
        error_password_confirmar = false;
        rehabilitarBoton();
        elm_password_confirmation.notify(``, { autoHideDelay: 0, showDuration: 0 });
    }

    return true;
}

/**
 * Comprueba que la longitud de la contraseña es mínimo de 8 caracteres
 */
function comprobarLongitudContrasenya(): boolean {
    let elm_password: JQuery<HTMLElement> = $("#password");
    if (String(elm_password.val()).trim().length < longitud_deseada_contrasenya) {
        if (!error_password_longitud) {
            error_password_longitud = true;
            $("#registro-submit").attr('disabled', "true");
            elm_password.notify("Contraseña demasiado corta", { autoHide: false, clickToHide: false });
        }

        return false;
    } else {
        error_password_longitud = false;
        rehabilitarBoton();
        elm_password.notify(``, { autoHideDelay: 0, showDuration: 0 });
    }

    return true;
}

/**
 * Comprueba que la contraseña no es insegura (sólo lanza aviso)
 */
function comprobarCaracteresContrasenya(): boolean {
    let elm_password: JQuery<HTMLElement> = $("#password");
    let contrasenya: string = String(elm_password.val()).trim();
    let patron: RegExp = /^([a-zA-Z0-9]*)$/

    if (patron.test(contrasenya)) {
        if (!error_password_caracteres) {
            error_password_caracteres = true;
            elm_password.notify("Contraseña insegura", "warn", { autoHide: false, clickToHide: false });
        }
        return false;
    } else {
        error_password_caracteres = false;
        elm_password.notify(``, { autoHideDelay: 0, showDuration: 0 });
    }

    return true;
}

/**
 * Comprueba la contraseña y la coteja con la confirmación
 */
function comprobarContrasenya(): void {
    if (!comprobarLongitudContrasenya()) return;

    comprobarCaracteresContrasenya();
    cotejarContrasenyas();
}

/**
 * Comprueba que el username es único, si no lo es avisa y deshabilita el botón registrarse
 */
async function comprobarUsernameUnico() {
    let elm_username: JQuery<HTMLElement> = $("#username");

    try {
        const result = await peticionAPIcomprobarUnico('username', String(elm_username.val()).trim());
        
        // Si la petición ha ido bien y el valor es único eliminamos el error por si existiese y rehabilitamos botón
        if (result.ok && result.valor_unico) {
            error_username_unico = false;
            (<any>elm_username).notify(``, { autoHideDelay: 0, showDuration: 0 });
            rehabilitarBoton();
        } else {
            // Si el resultado no es único, mostramos el error y deshabilitamos el botón
            if (result.ok && !result.valor_unico) {
                error_username_unico = true;
                elm_username.notify("Nombre usuario en uso", { autoHide: false, clickToHide: false });
                $("#registro-submit").attr('disabled', "true");
            } else {
                // Si el error se debe a que la petición no es OK, lanzamos error
                throw Error(result.mensaje);
            }
        }
    } catch (err) {
        console.log(err)
    }
}

/**
 * Comprueba que el email es único, si no lo es avisa y deshabilita el botón registrarse
 */
async function comprobarEmailUnico() {
    let elm_email: JQuery<HTMLElement> = $("#email");

    try {
        const result = await peticionAPIcomprobarUnico('email', String(elm_email.val()).trim());
        
        // Si la petición ha ido bien y el valor es único eliminamos el error por si existiese y rehabilitamos botón
        if (result.ok && result.valor_unico) {
            error_email_unico = false;
            elm_email.notify(``, { autoHideDelay: 0, showDuration: 0 });
            rehabilitarBoton();
        } else {
            // Si el resultado no es único, mostramos el error y deshabilitamos el botón
            if (result.ok && !result.valor_unico) {
                error_email_unico = true;
                elm_email.notify("Email ya registrado", { autoHide: false, clickToHide: false });
                $("#registro-submit").attr('disabled', "true");
            } else {
                // Si el error se debe a que la petición no es OK, lanzamos error
                throw Error(result.mensaje);
            }
        }
    } catch (err) {
        console.log(err)
    }
}

/**
 * Función que recibe una clave y valor y realiza una petición a la API para comprobar si existe un usuario con dicha clave y valor
 * @param clave nombre de la clave a comprobar
 * @param valor valor a cotejar
 * 
 * @returns devuelve una PROMESA con la respuesta de la API
 */
function peticionAPIcomprobarUnico(clave: string, valor: string): Promise<PeticionAPIUsuarioComprobarCampo> {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: '/api/usuario/comprobar-campo-unico',
            type: 'GET',
            data: {
                'clave' : clave,
                'valor' : valor
            },
        }).then(response => {
            resolve(response);
        }).catch(err => {
            reject(err);
        });
    });
}

/**
 * Rehabilita el botón de submit del formulario registro si se han quitado todos los errores
 */
function rehabilitarBoton(): void {
    if (!error_dni && !error_password_confirmar && !error_password_longitud 
        && !error_email_unico && !error_username_unico) {
        $("#registro-submit").removeAttr('disabled');
    }
}


