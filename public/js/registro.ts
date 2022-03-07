// Variable error que controla si se hace la animación o no
var error: boolean = false;

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
        error = false;
        $("#registro-submit").removeAttr('disabled');
        input_dni.notify(``, { autoHideDelay: 0, showDuration: 0 }); // <- para ocultar posible notificación previa
    } else {
        if (!error) {
            error = true;
            $("#registro-submit").attr('disabled', "true");
            input_dni.notify("DNI no válido.", { autoHide: false, clickToHide: false });
        }
    }
}

// Document ready
$.when( $.ready ).then(function() {
    // Listener input dni
    $("#dni").on('change', comprobarDNI);
});