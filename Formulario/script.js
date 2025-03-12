$(document).ready(function () {
    // Campos a validar
    const formFields = ["nombre", "apellido", "telefono", "correo"];

    // Mostrar/ocultar el campo de tipo de vehículo según la selección de "vehiculo"
    $("#vehiculo").change(function() {
        if ($(this).val() === "Sí") {
            $("#tipoVehiculoDiv").show();
        } else {
            $("#tipoVehiculoDiv").hide();
            $("#tipoVehiculo").val(""); // Limpiar el campo cuando se oculta
        }
    });

    // Validaciones en tiempo real
    formFields.forEach(field => {
        $("#" + field).on("input", function () {
            validarCampo(field);
        });
    });

    function validarCampo(id) {
        let $input = $("#" + id);
        let $errorMsg = $("#" + id + "Error");
        let valor = $input.val().trim();
        let valido = true;  // Bandera para saber si el campo es válido

        // Validación para nombre y apellido (solo letras y espacios)
        if (id === "nombre" || id === "apellido") {
            $("#nombre, #apellido").on("input", function () {
                $(this).val($(this).val().replace(/[^A-Za-záéíóúÁÉÍÓÚñÑ\s]/g, ""));
            });            
            // let regexTexto = /^[A-Za-záéíóúÁÉÍÓÚñÑ\s]+$/;
            // if (!regexTexto.test(valor)) {
            //     $errorMsg.show().text("Este campo solo puede contener letras y espacios.");
            //     valido = false;
            // }
        }

        // Validación para correo electrónico
        if (id === "correo") {
            let regexCorreo = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
            if (!regexCorreo.test(valor)) {
                $errorMsg.show().text("Por favor ingrese un correo electrónico válido.");
                valido = false;
            }
        }

        // Validación para teléfono (solo números y máximo 10 dígitos)
        if (id === "telefono") {
            let telefono = valor.replace(/\D/g, "");  // Eliminar caracteres no numéricos
            $input.val(telefono);  // Actualizar el campo con solo números

            if (telefono.length > 10) {
                telefono = telefono.substring(0, 10); // Limitar a 10 caracteres
                $input.val(telefono);  
            }

            if (telefono.length !== 10 && telefono.length > 0) {
                $errorMsg.show().text("El teléfono debe contener exactamente 10 dígitos.");
                valido = false;
            }

        }

        // Si el campo está vacío
        if (valor === "") {
            $errorMsg.show().text("Este campo es obligatorio.");
            valido = false;
        }

        if (valido) {
            $errorMsg.hide();  // Ocultar mensaje si es válido
        }

        return valido;  // Retorna si el campo es válido o no
    }

    // Validación general del formulario
    $("#registroForm").on("submit", function (e) {
        e.preventDefault(); // Evita el envío del formulario antes de la validación

        let valid = true;

        // Resetea los mensajes de error
        $('.error-msg').hide();

        // Validar todos los campos del formulario
        formFields.forEach(field => {
            if (!validarCampo(field)) {
                valid = false;  // Si algún campo es inválido, no se envía
            }
        });

        // Validación de preferencias entornos
        const entorno = $('input[name="entorno"]:checked');
        if (entorno.length === 0) {
            $("#entornoError").show();
            valid = false;
        }

        // Validación de preferencias musicales
        const musica = $('input[name="musica[]"]:checked');
        if (musica.length === 0) {
            $("#musicaError").show();
            valid = false;
        }

        // Validación de actividades de ocio
        const ocio = $('input[name="ocio[]"]:checked');
        if (ocio.length === 0) {
            $("#ocioError").show();
            valid = false;
        }

        if (valid) {
            this.submit(); // Enviar el formulario si es válido
        }
    });
});



// hacer que el campo tipoVehiculo sera requerido si se seleciona que SI se tiene auto propio
// La validación del correo que tire el mensaje de error cuando se de al button y esté mal escrito, o si se deja de escribir y está mal el formato
// lo del telefono que me mande el mensaje de error de q son 10 digitos cuando se da al button, maybe cuando se deja de escribir y no está completo
//meterle mas cosas para volverlo mas responsivo y animaciones para que sea dinamico