// Validación del formulario - Laura Sofía Ramos Rueda
// Escrito en JavaScript clásico (var, function) para que funcione en cualquier navegador
(function () {
    "use strict";

    function iniciar() {
        var formulario = document.getElementById("formularioContacto");
        var botonEnviar = document.getElementById("botonEnviar");
        var mensajeEstado = document.getElementById("mensajeEstado");
        if (!formulario) { return; }

        function limpio(id) {
            var campo = document.getElementById(id);
            return campo ? campo.value.replace(/^\s+|\s+$/g, "") : "";
        }

        function mostrarError(texto, id) {
            mensajeEstado.innerHTML = "";
            mensajeEstado.appendChild(document.createTextNode(texto));
            var campo = document.getElementById(id);
            if (campo) { campo.focus(); }
        }

        function cancelar(evento) {
            if (evento.preventDefault) { evento.preventDefault(); } else { evento.returnValue = false; }
            return false;
        }

        formulario.onsubmit = function (e) {
            var evento = e || window.event;

            // Validación nativa solo si el navegador la soporta
            if (typeof formulario.checkValidity === "function" && !formulario.checkValidity()) {
                if (typeof formulario.reportValidity === "function") { formulario.reportValidity(); }
                return cancelar(evento);
            }

            var correo = limpio("correo");
            var patronCorreo = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (limpio("nombre").length === 0) { mostrarError("Escribe tu nombre completo", "nombre"); return cancelar(evento); }
            if (correo.length === 0 || !patronCorreo.test(correo)) { mostrarError("Escribe un correo electrónico válido", "correo"); return cancelar(evento); }
            if (limpio("asunto").length === 0) { mostrarError("Selecciona un asunto", "asunto"); return cancelar(evento); }
            if (limpio("mensaje").length === 0) { mostrarError("Escribe el mensaje completo", "mensaje"); return cancelar(evento); }
            if (!document.getElementById("acepta_tratamiento").checked) { mostrarError("Debes aceptar el tratamiento de datos", "acepta_tratamiento"); return cancelar(evento); }

            // Evitar doble envío
            mensajeEstado.innerHTML = "";
            botonEnviar.disabled = true;
            botonEnviar.innerHTML = "Enviando...";
            return true;
        };

        formulario.onreset = function () {
            mensajeEstado.innerHTML = "";
            botonEnviar.disabled = false;
            botonEnviar.innerHTML = "Enviar mensaje";
        };
    }

    if (document.readyState === "loading") {
        if (document.addEventListener) { document.addEventListener("DOMContentLoaded", iniciar); }
        else { window.attachEvent("onload", iniciar); }
    } else {
        iniciar();
    }
})();
