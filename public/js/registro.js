var __awaiter = (this && this.__awaiter) || function (thisArg, _arguments, P, generator) {
    function adopt(value) { return value instanceof P ? value : new P(function (resolve) { resolve(value); }); }
    return new (P || (P = Promise))(function (resolve, reject) {
        function fulfilled(value) { try { step(generator.next(value)); } catch (e) { reject(e); } }
        function rejected(value) { try { step(generator["throw"](value)); } catch (e) { reject(e); } }
        function step(result) { result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected); }
        step((generator = generator.apply(thisArg, _arguments || [])).next());
    });
};
var __generator = (this && this.__generator) || function (thisArg, body) {
    var _ = { label: 0, sent: function() { if (t[0] & 1) throw t[1]; return t[1]; }, trys: [], ops: [] }, f, y, t, g;
    return g = { next: verb(0), "throw": verb(1), "return": verb(2) }, typeof Symbol === "function" && (g[Symbol.iterator] = function() { return this; }), g;
    function verb(n) { return function (v) { return step([n, v]); }; }
    function step(op) {
        if (f) throw new TypeError("Generator is already executing.");
        while (_) try {
            if (f = 1, y && (t = op[0] & 2 ? y["return"] : op[0] ? y["throw"] || ((t = y["return"]) && t.call(y), 0) : y.next) && !(t = t.call(y, op[1])).done) return t;
            if (y = 0, t) op = [op[0] & 2, t.value];
            switch (op[0]) {
                case 0: case 1: t = op; break;
                case 4: _.label++; return { value: op[1], done: false };
                case 5: _.label++; y = op[1]; op = [0]; continue;
                case 7: op = _.ops.pop(); _.trys.pop(); continue;
                default:
                    if (!(t = _.trys, t = t.length > 0 && t[t.length - 1]) && (op[0] === 6 || op[0] === 2)) { _ = 0; continue; }
                    if (op[0] === 3 && (!t || (op[1] > t[0] && op[1] < t[3]))) { _.label = op[1]; break; }
                    if (op[0] === 6 && _.label < t[1]) { _.label = t[1]; t = op; break; }
                    if (t && _.label < t[2]) { _.label = t[2]; _.ops.push(op); break; }
                    if (t[2]) _.ops.pop();
                    _.trys.pop(); continue;
            }
            op = body.call(thisArg, _);
        } catch (e) { op = [6, e]; y = 0; } finally { f = t = 0; }
        if (op[0] & 5) throw op[1]; return { value: op[0] ? op[1] : void 0, done: true };
    }
};
var PeticionAPIUsuarioComprobarCampo = (function () {
    function PeticionAPIUsuarioComprobarCampo(ok, mensaje, valor_unico) {
        this.ok = ok;
        this.mensaje = mensaje;
        this.valor_unico = valor_unico;
    }
    return PeticionAPIUsuarioComprobarCampo;
}());
$.when($.ready).then(function () {
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
var error_email_unico = false;
var error_username_unico = false;
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
        rehabilitarBoton();
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
        rehabilitarBoton();
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
        rehabilitarBoton();
        elm_password.notify("", { autoHideDelay: 0, showDuration: 0 });
    }
    return true;
}
function comprobarCaracteresContrasenya() {
    var elm_password = $("#password");
    var contrasenya = String(elm_password.val()).trim();
    var patron = /^([a-zA-Z0-9]*)$/;
    if (patron.test(contrasenya)) {
        if (!error_password_caracteres) {
            error_password_caracteres = true;
            elm_password.notify("Contraseña insegura", "warn", { autoHide: false, clickToHide: false });
        }
        return false;
    }
    else {
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
function comprobarUsernameUnico() {
    return __awaiter(this, void 0, void 0, function () {
        var elm_username, result, err_1;
        return __generator(this, function (_a) {
            switch (_a.label) {
                case 0:
                    elm_username = $("#username");
                    _a.label = 1;
                case 1:
                    _a.trys.push([1, 3, , 4]);
                    return [4, peticionAPIcomprobarUnico('username', String(elm_username.val()).trim())];
                case 2:
                    result = _a.sent();
                    if (result.ok && result.valor_unico) {
                        error_username_unico = false;
                        elm_username.notify("", { autoHideDelay: 0, showDuration: 0 });
                        rehabilitarBoton();
                    }
                    else {
                        if (result.ok && !result.valor_unico) {
                            error_username_unico = true;
                            elm_username.notify("Nombre usuario en uso", { autoHide: false, clickToHide: false });
                            $("#registro-submit").attr('disabled', "true");
                        }
                        else {
                            throw Error(result.mensaje);
                        }
                    }
                    return [3, 4];
                case 3:
                    err_1 = _a.sent();
                    console.log(err_1);
                    return [3, 4];
                case 4: return [2];
            }
        });
    });
}
function comprobarEmailUnico() {
    return __awaiter(this, void 0, void 0, function () {
        var elm_email, result, err_2;
        return __generator(this, function (_a) {
            switch (_a.label) {
                case 0:
                    elm_email = $("#email");
                    _a.label = 1;
                case 1:
                    _a.trys.push([1, 3, , 4]);
                    return [4, peticionAPIcomprobarUnico('email', String(elm_email.val()).trim())];
                case 2:
                    result = _a.sent();
                    if (result.ok && result.valor_unico) {
                        error_email_unico = false;
                        elm_email.notify("", { autoHideDelay: 0, showDuration: 0 });
                        rehabilitarBoton();
                    }
                    else {
                        if (result.ok && !result.valor_unico) {
                            error_email_unico = true;
                            elm_email.notify("Email ya registrado", { autoHide: false, clickToHide: false });
                            $("#registro-submit").attr('disabled', "true");
                        }
                        else {
                            throw Error(result.mensaje);
                        }
                    }
                    return [3, 4];
                case 3:
                    err_2 = _a.sent();
                    console.log(err_2);
                    return [3, 4];
                case 4: return [2];
            }
        });
    });
}
function peticionAPIcomprobarUnico(clave, valor) {
    return new Promise(function (resolve, reject) {
        $.ajax({
            url: '/api/usuario/comprobar-campo-unico',
            type: 'GET',
            data: {
                'clave': clave,
                'valor': valor
            }
        }).then(function (response) {
            resolve(response);
        })["catch"](function (err) {
            reject(err);
        });
    });
}
function rehabilitarBoton() {
    if (!error_dni && !error_password_confirmar
        && !error_password_longitud && !error_password_caracteres
        && !error_email_unico && !error_username_unico) {
        $("#registro-submit").removeAttr('disabled');
    }
}
//# sourceMappingURL=registro.js.map