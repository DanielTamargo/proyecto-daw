$.when($.ready).then(function () {
    $("#dni").on('change', comprobarDNI);
    $("#password").on('change', comprobarContrasenya);
    $("#password-confirm").on('change', comprobarContrasenya);
    if ($("#cargar-registro").val() === "true") {
        if ($("#nuevo-administrador").val())
            cargarSoloRegistro();
        else
            $("#form2").trigger('click');
    }
});
var longitud_deseada_contrasenya = 8;
var error_dni = false;
var error_password_confirmar = false;
var error_password_longitud = false;
var error_password_caracteres = false;
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
function cotejarContrasenyas() {
    var elm_password_confirmation = $("#password-confirm");
    var password = String($("#password").val()).trim();
    var password_confirmation = String(elm_password_confirmation.val()).trim();
    if (password_confirmation.length > 0 && password !== password_confirmation) {
        if (!error_password_confirmar) {
            error_password_confirmar = true;
            $("#registro-submit").attr('disabled', "true");
            elm_password_confirmation.notify("Las contraseñas no coinciden", { autoHide: false, clickToHide: false });
        }
        return false;
    }
    else {
        error_password_confirmar = false;
        $("#registro-submit").removeAttr('disabled');
        elm_password_confirmation.notify("", { autoHideDelay: 0, showDuration: 0 });
    }
    return true;
}
function comprobarLongitudContrasenya() {
    var elm_password = $("#password");
    if (String(elm_password.val()).trim().length < longitud_deseada_contrasenya) {
        if (!error_password_longitud) {
            error_password_longitud = true;
            $("#registro-submit").attr('disabled', "true");
            elm_password.notify("Contraseña demasiado corta", { autoHide: false, clickToHide: false });
        }
        return false;
    }
    else {
        error_password_longitud = false;
        $("#registro-submit").removeAttr('disabled');
        elm_password.notify("", { autoHideDelay: 0, showDuration: 0 });
    }
    return true;
}
function comprobarCaracteresContrasenya() {
    var elm_password = $("#password");
    var contrasenya = String(elm_password.val()).trim();
    var patron = /^([a-zA-Z0-9]*)$/;
    if (patron.test(contrasenya)) {
        console.log('si');
        if (!error_password_caracteres) {
            error_password_caracteres = true;
            elm_password.notify("Contraseña insegura", "warn", { autoHide: false, clickToHide: false });
        }
        return false;
    }
    else {
        console.log('no');
        error_password_caracteres = false;
        elm_password.notify("", { autoHideDelay: 0, showDuration: 0 });
    }
    return true;
}
function comprobarContrasenya() {
    if (!comprobarLongitudContrasenya())
        return;
    comprobarCaracteresContrasenya();
    cotejarContrasenyas();
}
//# sourceMappingURL=registro.js.map