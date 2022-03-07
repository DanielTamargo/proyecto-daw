$.when($.ready).then(function () {
    $("#dni").on('change', comprobarDNI);
    $("#password-confirm").on('change', comprobarContrasenyas);
});
var error_dni = false;
var error_password = false;
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
        error_dni = false;
        $("#registro-submit").removeAttr('disabled');
        input_dni.notify("", { autoHideDelay: 0, showDuration: 0 });
    }
    else {
        if (!error_dni) {
            error_dni = true;
            $("#registro-submit").attr('disabled', "true");
            input_dni.notify("DNI no válido.", { autoHide: false, clickToHide: false });
        }
    }
}
function comprobarContrasenyas() {
    var elm_password_confirmation = $("#password-confirm");
    var password = String($("#password").val()).trim();
    var password_confirmation = String(elm_password_confirmation.val()).trim();
    if (password !== password_confirmation) {
        if (!error_password) {
            error_password = true;
            $("#registro-submit").attr('disabled', "true");
            elm_password_confirmation.notify("Las contraseñas no coinciden", { autoHide: false, clickToHide: false });
        }
    }
    else {
        error_password = false;
        $("#registro-submit").removeAttr('disabled');
        elm_password_confirmation.notify("", { autoHideDelay: 0, showDuration: 0 });
    }
}
//# sourceMappingURL=registro.js.map