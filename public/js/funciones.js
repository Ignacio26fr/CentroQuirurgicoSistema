$(document).ready(function() {
    // Evento de búsqueda y carga para el diagnóstico primario
    $('#filtroPrimario').on('input', function() {
        var filtroPrimario = $(this).val();
        $.ajax({
            url: '/formulario/obtenerOpcionesPrimario',
            method: 'GET',
            data: { filtroPrimario: filtroPrimario },
            success: function(data) {
                $('#opcionesPrimario').empty();
                $.each(data, function (index, option) {
                    var $opcion = $('<div class="opcion-diagnostico select-option" data-id="' + option.id + '">' + option.nombre + '</div>');
                    $('#opcionesPrimario').append($opcion);
                });
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });


    $('#opcionesPrimario').on('click', '.opcion-diagnostico', function() {
        var nombreDiagnostico = $(this).text();
        var idDiagnostico = $(this).data('id');
        $('#filtroPrimario').val(nombreDiagnostico);
        $('#primarioSeleccionado').val(idDiagnostico);
        $('#opcionesPrimario').empty();
    });

    $(document).on('click', function(event) {
        if (!$(event.target).closest('#opcionesPrimario').length && !$(event.target).is('#filtroPrimario')) {
            $('#opcionesPrimario').empty();
        }
    });

    $('#filtroSecundario').on('input', function() {
        var filtroSecundario = $(this).val();
        $.ajax({
            url: '/formulario/obtenerOpcionesSecundario',
            method: 'GET',
            data: { filtroSecundario: filtroSecundario },
            success: function(data) {
                $('#opcionesSecundario').empty();
                $.each(data, function (index, option) {
                    var $opcion = $('<div class="opcion-diagnostico select-option" data-id="' + option.id + '">' + option.nombre + '</div>');
                    $('#opcionesSecundario').append($opcion);
                });
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });

    $('#opcionesSecundario').on('click', '.opcion-diagnostico', function() {
        var nombreDiagnostico = $(this).text();
        var idDiagnostico = $(this).data('id');
        $('#filtroSecundario').val(nombreDiagnostico);
        $('#secundarioSeleccionado').val(idDiagnostico);
        $('#opcionesSecundario').empty();
    });

    $(document).on('click', function(event) {
        if (!$(event.target).closest('#opcionesSecundario').length && !$(event.target).is('#filtroSecundario')) {
            $('#opcionesSecundario').empty();
        }
    });
});

$(document).ready(function() {
    $('#espQuirurgica').change(function() {
        var idEspQuirurgica = $(this).val();
        $.ajax({
            url: '/formulario/obtenerUnidadesFuncionales',
            method: 'GET',
            data: { idEspQuirurgica: idEspQuirurgica },
            success: function(data) {
                $('#unidadFuncional').empty();

                // Agregar opción vacía por defecto
                $('#unidadFuncional').append($('<option>', {
                    value: '',
                    text: 'Seleccionar'
                }));

                $.each(data, function(index, unidad) {
                    $('#unidadFuncional').append($('<option>', {
                        value: unidad.idUnidadFuncional,
                        text: unidad.nombre
                    }));
                });
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });


    $('#unidadFuncional').change(function() {
        var idUnidadFuncionalSeleccionada = $(this).val();
        $('#idUnidadFuncionalSeleccionada').val(idUnidadFuncionalSeleccionada);
    });
});

$(document).ready(function() {
    $('#unidadFuncional').change(function() {
        var idUnidadFuncional = $(this).val();
        console.log(idUnidadFuncional);
        $.ajax({
            url: '/formulario/obtenerSitiosAnatomicos',
            method: 'GET',
            data: { idUnidadFuncional: idUnidadFuncional },
            success: function(data) {
                $('#sitioAnatomico').empty();

                // Agregar opción vacía por defecto
                $('#sitioAnatomico').append($('<option>', {
                    value: '',
                    text: 'Seleccionar'
                }));

                $.each(data, function(index, sitio) {
                    $('#sitioAnatomico').append($('<option>', {
                        value: sitio.idSitioAnatomico,
                        text: sitio.nombre
                    }));
                });
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });
});





