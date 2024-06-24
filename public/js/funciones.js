$(document).ready(function() {
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
        console.log(idDiagnostico);
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
        console.log(idEspQuirurgica);
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
                        value: unidad.id,
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
        console.log(idUnidadFuncionalSeleccionada)
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
                        value: sitio.id,
                        text: sitio.nombre
                    }));
                });
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });
    $('#sitioAnatomico').change(function() {
        var idSitioAnatomicoSeleccionada = $(this).val();
        console.log(idSitioAnatomicoSeleccionada);
        $('#idSitioAnatomicoSeleccionada').val(idSitioAnatomicoSeleccionada);
    });
});


$(document).ready(function() {
    $('#sitioAnatomico').change(function() {
        var idSitioAnatomico = $(this).val();
        console.log(idSitioAnatomico);
        $.ajax({
            url: '/formulario/obtenerActosQuirurgicoPrincipales',
            method: 'GET',
            data: { idSitioAnatomico: idSitioAnatomico },
            success: function(data) {
                $('#actoQuirurgicoPrincipal').empty();

                $('#actoQuirurgicoPrincipal').append($('<option>', {
                    value: '',
                    text: 'Seleccionar'
                }));

                $.each(data, function(index, acto) {
                    $('#actoQuirurgicoPrincipal').append($('<option>', {
                        value: acto.id,
                        text: acto.nombre
                    }));
                });
            },
            error: function(xhr, status, error) {
                console.error(error);
                console.log(this.data);
            }
        });
    });
    $('#actoQuirurgicoPrincipal').change(function() {
        var idActoQuirurgicoPrincipal = $(this).val();
        console.log(idActoQuirurgicoPrincipal);
        $('#idActoQuirurgicoPrincipalSeleccionado').val(idActoQuirurgicoPrincipal);
    });
});


//Cirujanos

$(document).ready(function() {
    $('#filtroCirujano').on('input', function () {
        var filtroCirujano = $(this).val();
        console.log(filtroCirujano);
        $.ajax({
            url: '/formulario/obtenerCirujano',
            method: 'GET',
            data: { filtroCirujano: filtroCirujano},
            success: function (data) {
                $('#opcionesCirujano').empty();
                $.each(data, function (index, option) {
                    var $opcion = $('<div class="opcion-cirujano select-option" data-id="' + option.id + '">' + option.nombre + ' ' + option.apellido + ' ' + option.matricula + '</div>');
                    $('#opcionesCirujano').append($opcion);
                });
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });


    $('#opcionesCirujano').on('click', '.opcion-cirujano', function () {
        var nombreCirujano = $(this).text();
        var idCirujano = $(this).data('id');
        console.log(idCirujano);
        $('#filtroCirujano').val(nombreCirujano);
        $('#cirujanoSeleccionado').val(idCirujano);
        $('#opcionesCirujano').empty();
    });

    $(document).on('click', function (event) {
        if (!$(event.target).closest('#opcionesCirujano').length && !$(event.target).is('#filtroCirujano')) {
            $('#opcionesCirujano').empty();
        }
    });

});


// Primer ayudandante

$(document).ready(function() {
    $('#filtroPrimer').on('input', function () {
        var filtroPrimer = $(this).val();
        console.log(filtroPrimer);
        $.ajax({
            url: '/formulario/obtenerPrimerAyudante',
            method: 'GET',
            data: { filtroPrimer: filtroPrimer},
            success: function (data) {
                $('#opcionesPrimer').empty();
                $.each(data, function (index, option) {
                    var $opcion = $('<div class="opcion-primer select-option" data-id="' + option.id + '">' + option.nombre + ' ' + option.apellido + ' ' + option.matricula + '</div>');
                    $('#opcionesPrimer').append($opcion);
                });
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });


    $('#opcionesPrimer').on('click', '.opcion-primer', function () {
        var nombrePrimer = $(this).text();
        var idPrimerAyudante = $(this).data('id');
        $('#filtroPrimer').val(nombrePrimer);
        $('#primerSeleccionado').val(idPrimerAyudante);
        $('#opcionesPrimer').empty();
    });

    $(document).on('click', function (event) {
        if (!$(event.target).closest('#opcionesPrimer').length && !$(event.target).is('#filtroPrimer')) {
            $('#opcionesPrimer').empty();
        }
    });

});

//Segundo ayudante

$(document).ready(function() {
    $('#filtroSegundo').on('input', function () {
        var filtroSegundo = $(this).val();
        console.log(filtroSegundo);
        $.ajax({
            url: '/formulario/obtenerSegundoAyudante',
            method: 'GET',
            data: { filtroSegundo: filtroSegundo},
            success: function (data) {
                $('#opcionesSegundo').empty();
                $.each(data, function (index, option) {
                    var $opcion = $('<div class="opcion-segundo select-option" data-id="' + option.id + '">' + option.nombre + ' ' + option.apellido + ' ' + option.matricula + '</div>');
                    $('#opcionesSegundo').append($opcion);
                });
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });


    $('#opcionesSegundo').on('click', '.opcion-segundo', function () {
        var nombreSegundo = $(this).text();
        var idSegundoAyudante = $(this).data('id');
        $('#filtroSegundo').val(nombreSegundo);
        $('#segundoSeleccionado').val(idSegundoAyudante);
        $('#opcionesSegundo').empty();
    });

    $(document).on('click', function (event) {
        if (!$(event.target).closest('#opcionesSegundo').length && !$(event.target).is('#filtroSegundo')) {
            $('#opcionesSegundo').empty();
        }
    });

});


//Anestesista

$(document).ready(function() {
    $('#filtroAnestesista').on('input', function () {
        var filtroAnestesista = $(this).val();
        $.ajax({
            url: '/formulario/obtenerAnestesistas',
            method: 'GET',
            data: { filtroAnestesista: filtroAnestesista},
            success: function (data) {
                $('#opcionesAnestesista').empty();
                $.each(data, function (index, option) {
                    var $opcion = $('<div class="opcion-anestesista select-option" data-id="' + option.id + '">' + option.nombre + ' ' + option.apellido + ' ' + option.matricula + '</div>');
                    $('#opcionesAnestesista').append($opcion);
                });
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });


    $('#opcionesAnestesista').on('click', '.opcion-anestesista', function () {
        var nombreAnestesista = $(this).text();
        var idAnestesista = $(this).data('id');
        $('#filtroAnestesista').val(nombreAnestesista);
        $('#anestesistaSeleccionado').val(idAnestesista);
        $('#opcionesAnestesista').empty();
    });

    $(document).on('click', function (event) {
        if (!$(event.target).closest('#opcionesAnestesista').length && !$(event.target).is('#filtroAnestesista')) {
            $('#opcionesAnestesista').empty();
        }
    });

});

//Neonatologo


$(document).ready(function() {
    $('#filtroNeo').on('input', function () {
        var filtroNeo = $(this).val();
        $.ajax({
            url: '/formulario/obtenerNeonatologo',
            method: 'GET',
            data: { filtroNeo: filtroNeo},
            success: function (data) {
                $('#opcionesNeo').empty();
                $.each(data, function (index, option) {
                    var $opcion = $('<div class="opcion-neo select-option" data-id="' + option.id + '">' + option.nombre + ' ' + option.apellido + ' ' + option.matricula + '</div>');
                    $('#opcionesNeo').append($opcion);
                });
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });


    $('#opcionesNeo').on('click', '.opcion-neo', function () {
        var nombreNeo = $(this).text();
        var idNeo = $(this).data('id');
        $('#filtroNeo').val(nombreNeo);
        $('#neoSeleccionado').val(idNeo);
        $('#opcionesNeo').empty();
    });

    $(document).on('click', function (event) {
        if (!$(event.target).closest('#opcionesNeo').length && !$(event.target).is('#filtroNeo')) {
            $('#opcionesNeo').empty();
        }
    });

});

//Tecnico anestesista
$(document).ready(function() {
    $('#filtroTecnico').on('input', function () {
        var filtroTecnico = $(this).val();
        $.ajax({
            url: '/formulario/obtenerTecnico',
            method: 'GET',
            data: { filtroTecnico: filtroTecnico},
            success: function (data) {
                $('#opcionesTecnico').empty();
                $.each(data, function (index, option) {
                    var $opcion = $('<div class="opcion-tecnico select-option" data-id="' + option.id + '">' + option.nombre + ' ' + option.apellido + ' ' + option.matricula + '</div>');
                    $('#opcionesTecnico').append($opcion);
                });
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });


    $('#opcionesTecnico').on('click', '.opcion-tecnico', function () {
        var nombreTecnico = $(this).text();
        var idTecnico = $(this).data('id');
        $('#filtroTecnico').val(nombreTecnico);
        $('#tecnicoSeleccionado').val(idTecnico);
        $('#opcionesTecnico').empty();
    });

    $(document).on('click', function (event) {
        if (!$(event.target).closest('#opcionesTecnico').length && !$(event.target).is('#filtroTecnico')) {
            $('#opcionesTecnico').empty();
        }
    });

});

//Cajas quirurgicas
$(document).ready(function() {
    $('#filtroCaja').on('input', function () {
        var filtroCaja = $(this).val();
        $.ajax({
            url: '/formulario/obtenerCajas',
            method: 'GET',
            data: { filtroCaja: filtroCaja},
            success: function (data) {
                $('#opcionesCaja').empty();
                $.each(data, function (index, option) {
                    var $opcion = $('<div class="opcion-caja select-option" data-id="' + option.id + '">' + option.nombre + '</div>');
                    $('#opcionesCaja').append($opcion);
                });
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });


    $('#opcionesCaja').on('click', '.opcion-caja', function () {
        var nombreCaja = $(this).text();
        var idCaja = $(this).data('id');
        console.log(idCaja);
        $('#filtroCaja').val(nombreCaja);
        $('#cajaSeleccionado').val(idCaja);
        $('#opcionesCaja').empty();
    });

    $(document).on('click', function (event) {
        if (!$(event.target).closest('#opcionesCaja').length && !$(event.target).is('#filtroCaja')) {
            $('#opcionesCaja').empty();
        }
    });

});

//Codigo de practicas

$(document).ready(function() {
    $('#filtroCodigo').on('input', function () {
        var filtroCodigo = $(this).val();
        console.log(filtroCodigo);
        $.ajax({
            url: '/formulario/obtenerCodigos',
            method: 'GET',
            data: { filtroCodigo: filtroCodigo },
            success: function (data) {
                $('#opcionesCodigo').empty();
                $.each(data, function (index, option) {
                    var $opcion = $('<div class="opcion-codigo select-option" data-id="' + option.id + '">' + option.nombre + '</div>');
                    $('#opcionesCodigo').append($opcion);
                });
            },
            error: function (xhr, status, error) {
                console.error(error);
                console.log(this.data)
            }
        });
    });


    $('#opcionesCodigo').on('click', '.opcion-codigo', function () {
        var nombreCodigo = $(this).text();
        var idCodigo = $(this).data('id');
        console.log(idCodigo);
        $('#filtroCodigo').val(nombreCodigo);
        $('#codigosSeleccionado').val(idCodigo);
        $('#opcionesCodigo').empty();
    });

    $(document).on('click', function (event) {
        if (!$(event.target).closest('#opcionesCodigo').length && !$(event.target).is('#filtroCodigo')) {
            $('#opcionesCodigo').empty();
        }
    });

});
//Material protesico primario
$(document).ready(function() {
    $('#filtroMaterial').on('input', function () {
        var filtroMaterial = $(this).val();
        console.log(filtroMaterial);
        $.ajax({
            url: '/formulario/obtenerMaterialProtesico',
            method: 'GET',
            data: { filtroMaterial: filtroMaterial },
            success: function (data) {
                $('#opcionesMaterial').empty();
                $.each(data, function (index, option) {
                    var $opcion = $('<div class="opcion-material select-option" data-id="' + option.id + '">' + option.nombre + '</div>');
                    $('#opcionesMaterial').append($opcion);
                });
            },
            error: function (xhr, status, error) {
                console.error(error);
                console.log(this.data)
            }
        });
    });


    $('#opcionesMaterial').on('click', '.opcion-material', function () {
        var nombreMaterial = $(this).text();
        var idMaterial = $(this).data('id');
        console.log(idMaterial);
        $('#filtroMaterial').val(nombreMaterial);
        $('#materialSeleccionado').val(idMaterial);
        $('#opcionesMaterial').empty();
    });

    $(document).on('click', function (event) {
        if (!$(event.target).closest('#opcionesMaterial').length && !$(event.target).is('#filtroMaterial')) {
            $('#opcionesMaterial').empty();
        }
    });

});



