    // Habilitar la validación en todos los formularios
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            // Selecciona todos los formularios en la página
            var forms = document.querySelectorAll('form');
            // Itera sobre cada formulario
            Array.prototype.slice.call(forms).forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault(); // Evita el envío si es inválido
                        event.stopPropagation(); // Detiene la propagación del evento
                    }
                    form.classList.add('was-validated'); // Activa los estilos de Bootstrap
                }, false);
            });
        }, false);
    })();