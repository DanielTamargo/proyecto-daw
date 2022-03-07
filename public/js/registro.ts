// Document ready
$.when( $.ready ).then(function() {
    // Listener input dni
    $("#dni").on('change', comprobarDNI);

    // Listeners comprobar contraseña
    $("#password").on('change', comprobarContrasenya);
    $("#password-confirm").on('change', comprobarContrasenya);
});


// Longitud de contraseña deseada
var longitud_deseada_contrasenya: number = 8;

// Variables error que controlan si se hace la animación o no
var error_dni: boolean = false;
var error_password_confirmar: boolean = false;
var error_password_longitud: boolean = false;
var error_password_caracteres: boolean = false;

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
        $("#registro-submit").removeAttr('disabled');
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
        $("#registro-submit").removeAttr('disabled');
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
        $("#registro-submit").removeAttr('disabled');
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
        console.log('si')
        if (!error_password_caracteres) {
            error_password_caracteres = true;
            elm_password.notify("Contraseña insegura", "warn", { autoHide: false, clickToHide: false });
        }
        return false;
    } else {
        console.log('no')
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