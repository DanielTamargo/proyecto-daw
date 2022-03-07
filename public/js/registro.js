var error = false;
function validarDNI(dni) {
    if (typeof dni != "string") {
        return false;
    }
    dni = dni.toUpperCase();
    var regex_dni = /^\d{8}[a-zA-Z]$/;
    if (!regex_dni.test(dni)) {
        return false;
    }
    var lista_letras = 'TRWAGMYFPDXBNJZSQVHLCKET';
    var numero = Number(dni.substring(0, dni.length - 1));
    var letra_dni = dni.substring(dni.length - 1);
    if (letra_dni != lista_letras.charAt(numero % 23)) {
        return false;
    }
    return true;
}
function comprobarDNI() {
    var input_dni = $("#dni");
    var dni_valido = validarDNI(String(input_dni.val()));
    if (dni_valido) {
        error = false;
        $("#registro-submit").removeAttr('disabled');
        input_dni.notify("", { autoHideDelay: 0, showDuration: 0 });
    }
    else {
        if (!error) {
            error = true;
            $("#registro-submit").attr('disabled', "true");
            input_dni.notify("DNI no válido.", { autoHide: false, clickToHide: false });
        }
    }
}
$.when($.ready).then(function () {
    $("#dni").on('change', comprobarDNI);
});
//# sourceMappingURL=registro.js.map