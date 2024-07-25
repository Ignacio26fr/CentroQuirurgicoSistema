$(document).ready(function() {
    $('#filtroPrimario').on('input', function () {
        var filtroPrimario = $(this).val();
        $.ajax({
            url: '/formulario/obtenerOpcionesPrimario',
            method: 'GET',
            data: {filtroPrimario: filtroPrimario},
            success: function (data) {
                $('#opcionesPrimario').empty();
                $.each(data, function (index, option) {
                    var $opcion = $('<div class="opcion-diagnostico select-option" data-id="' + option.id + '">' + option.nombre + '</div>');
                    $('#opcionesPrimario').append($opcion);
                });
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });


    $('#opcionesPrimario').on('click', '.opcion-diagnostico', function () {
        var nombreDiagnostico = $(this).text();
        var idDiagnostico = $(this).data('id');
        console.log(idDiagnostico);
        $('#filtroPrimario').val(nombreDiagnostico);
        $('#primarioSeleccionado').val(idDiagnostico);
        $('#opcionesPrimario').empty();
    });

    $(document).on('click', function (event) {
        if (!$(event.target).closest('#opcionesPrimario').length && !$(event.target).is('#filtroPrimario')) {
            $('#opcionesPrimario').empty();
        }
    });

    $('#filtroSecundario').on('input', function () {
        var filtroSecundario = $(this).val();
        $.ajax({
            url: '/formulario/obtenerOpcionesSecundario',
            method: 'GET',
            data: {filtroSecundario: filtroSecundario},
            success: function (data) {
                $('#opcionesSecundario').empty();
                $.each(data, function (index, option) {
                    var $opcion = $('<div class="opcion-diagnostico select-option" data-id="' + option.id + '">' + option.nombre + '</div>');
                    $('#opcionesSecundario').append($opcion);
                });
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
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
});
$(document).ready(function() {
    let fieldIndex = 1;
    const maxFields = 3;

    function checkAndShowExtraFields() {

        if ($('.espQuirurgica').last().val() !== '0' &&
            $('.unidadFuncional').last().val() !== '0' &&
            $('.sitioAnatomico').last().val() !== '0' &&
            $('.actoQuirurgico').last().val() !== '0') {
            if (fieldIndex < maxFields) {
                addNewFields();
            }
        }
    }

    function fetchUnits(idEspQuirurgica, $unitSelect, callback) {
        $.ajax({
            url: '/formulario/obtenerUnidadesFuncionales',
            method: 'GET',
            data: { idEspQuirurgica: idEspQuirurgica },
            success: function(data) {
                $unitSelect.empty().append($('<option>', { value: '0', text: 'Seleccionar' }));
                $.each(data, function(index, unidad) {
                    $unitSelect.append($('<option>', { value: unidad.id, text: unidad.nombre }));
                });
                callback();
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }

    function fetchSites(idUnidadFuncional, $siteSelect, callback) {
        $.ajax({
            url: '/formulario/obtenerSitiosAnatomicos',
            method: 'GET',
            data: { idUnidadFuncional: idUnidadFuncional },
            success: function(data) {
                $siteSelect.empty().append($('<option>', { value: '0', text: 'Seleccionar' }));
                $.each(data, function(index, sitio) {
                    $siteSelect.append($('<option>', { value: sitio.id, text: sitio.nombre }));
                });
                callback();
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }
    function fetchActo(idSitioAnatomico, $actoSelect, callback) {
        $.ajax({
            url: '/formulario/obtenerActosQuirurgico',
            method: 'GET',
            data: {idSitioAnatomico: idSitioAnatomico},
            success: function (data) {
                $actoSelect.empty().append($('<option>', {value: '0', text: 'Seleccionar'}));
                $.each(data, function (index, acto) {
                    $actoSelect.append($('<option>', {value: acto.id, text: acto.nombre }))
                });
                callback();
            },
            error: function (xhr, status, error) {
                console.error(error);
            }

        });
    }

    function setupFieldEvents($container) {
        $container.find('.espQuirurgica').change(function() {
            var idEspQuirurgica = $(this).val();
            var $unitSelect = $container.find('.unidadFuncional');
            fetchUnits(idEspQuirurgica, $unitSelect, checkAndShowExtraFields);
        });

        $container.find('.unidadFuncional').change(function() {
            var idUnidadFuncional = $(this).val();
            $container.find('.idUnidadFuncionalSeleccionada').val(idUnidadFuncional);
            var $siteSelect = $container.find('.sitioAnatomico');
            fetchSites(idUnidadFuncional, $siteSelect, checkAndShowExtraFields);
        });

        $container.find('.sitioAnatomico').change(function() {
            var idSitioAnatomico = $(this).val();
            $container.find('.idSitioAnatomicoSeleccionada').val(idSitioAnatomico);
            var $actoSelect = $container.find('.actoQuirurgico');
            fetchActo(idSitioAnatomico, $actoSelect, checkAndShowExtraFields);
            checkAndShowExtraFields();
        });

        $container.find('.actoQuirurgico').change(function() {
            var idActoQuirurgico = $(this).val();
            $container.find('.idActoQuirurgicoSeleccionado').val(idActoQuirurgico);
            checkAndShowExtraFields();
        });
    }

    function addNewFields() {
        var $newFields = $('#field-container').clone();
        $newFields.find('select, input[type="hidden"]').each(function() {
            var newId = $(this).attr('id').replace('_0', '_' + fieldIndex);
            var newName = $(this).attr('name').replace('_0', '_' + fieldIndex);
            $(this).attr('id', newId).attr('name', newName).val('0');
            $(this).attr('id', newId).attr('name', newName).val('0').removeAttr('required');
        });

        $newFields.find('.espQuirurgicaLabel').text('Especialidad quirúrgica ' + (fieldIndex + 1)).css('background', 'white');
        $newFields.find('.unidadFuncionalLabel').text('Unidad funcional ' + (fieldIndex + 1)).css('background', 'white');
        $newFields.find('.sitioAnatomicoLabel').text('Sitio Anatomico ' + (fieldIndex + 1)).css('background', 'white');
        $newFields.find('.actoQuirurgicoLabel').text('Acto Quirúrgico ' + (fieldIndex + 1)).css('background', 'white');

        $newFields.addClass('field-container')

        $('#additional-fields').append($newFields);
        setupFieldEvents($newFields);

        fieldIndex++;
    }

    setupFieldEvents($('#field-container'));
});




//Cirujanos
$(document).ready(function() {
    let fieldIndex = 1;
    const maxFields = 3;

    function checkAndShowExtraFields() {
        if ($('.filtroCirujano').last().val() !== '') {
            if (fieldIndex < maxFields) {
                addNewFields();
            }
        }
    }

    function setupFieldEvents($container) {
        $container.find('.filtroCirujano, .filtroPrimer, .filtroSegundo').on('input', function() {
            checkAndShowExtraFields();
        });

        // Autocomplete events for Cirujano
        $container.find('.filtroCirujano').on('input', function () {
            var filtroCirujano = $(this).val();
            var $opcionesCirujano = $(this).next('.opcion-cirujano');
            $.ajax({
                url: '/formulario/obtenerCirujano',
                method: 'GET',
                data: { filtroCirujano: filtroCirujano },
                success: function (data) {
                    $opcionesCirujano.empty();
                    $.each(data, function (index, option) {
                        var $opcion = $('<div class="opcion-cirujano select-option" data-id="' + option.id + '">' + option.nombre + ' ' + option.apellido + ' ' + option.matricula + '</div>');
                        $opcionesCirujano.append($opcion);
                    });
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });
        });

        $container.find('.opcion-cirujano').on('click', '.opcion-cirujano', function () {
            var nombreCirujano = $(this).text();
            var idCirujano = $(this).data('id');
            var $filtroCirujano = $(this).closest('.form-group').find('.filtroCirujano');
            var $cirujanoSeleccionado = $(this).closest('.form-group').find('input[type="hidden"]');
            $filtroCirujano.val(nombreCirujano);
            $cirujanoSeleccionado.val(idCirujano);
            $(this).parent().empty();
        });

        $(document).on('click', function (event) {
            if (!$(event.target).closest('.opcion-cirujano').length && !$(event.target).is('.filtroCirujano')) {
                $('.opcion-cirujano').empty();
            }
        });


        $container.find('.filtroPrimer').on('input', function () {
            var filtroPrimer = $(this).val();
            var $opcionesPrimer = $(this).next('.opcion-primer');
            $.ajax({
                url: '/formulario/obtenerPrimerAyudante',
                method: 'GET',
                data: { filtroPrimer: filtroPrimer },
                success: function (data) {
                    $opcionesPrimer.empty();
                    $.each(data, function (index, option) {
                        var $opcion = $('<div class="opcion-primer select-option" data-id="' + option.id + '">' + option.nombre + ' ' + option.apellido + ' ' + option.matricula + '</div>');
                        $opcionesPrimer.append($opcion);
                    });
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });
        });

        $container.find('.opcion-primer').on('click', '.opcion-primer', function () {
            var nombrePrimer = $(this).text();
            var idPrimerAyudante = $(this).data('id');
            var $filtroPrimer = $(this).closest('.form-group').find('.filtroPrimer');
            var $primerSeleccionado = $(this).closest('.form-group').find('input[type="hidden"]');
            $filtroPrimer.val(nombrePrimer);
            $primerSeleccionado.val(idPrimerAyudante);
            $(this).parent().empty();
        });

        $(document).on('click', function (event) {
            if (!$(event.target).closest('.opcion-primer').length && !$(event.target).is('.filtroPrimer')) {
                $('.opcion-primer').empty();
            }
        });

        // Autocomplete events for Segundo Ayudante
        $container.find('.filtroSegundo').on('input', function () {
            var filtroSegundo = $(this).val();
            var $opcionesSegundo = $(this).next('.opcion-segundo');
            $.ajax({
                url: '/formulario/obtenerSegundoAyudante',
                method: 'GET',
                data: { filtroSegundo: filtroSegundo },
                success: function (data) {
                    $opcionesSegundo.empty();
                    $.each(data, function (index, option) {
                        var $opcion = $('<div class="opcion-segundo select-option" data-id="' + option.id + '">' + option.nombre + ' ' + option.apellido + ' ' + option.matricula + '</div>');
                        $opcionesSegundo.append($opcion);
                    });
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });
        });

        $container.find('.opcion-segundo').on('click', '.opcion-segundo', function () {
            var nombreSegundo = $(this).text();
            var idSegundoAyudante = $(this).data('id');
            var $filtroSegundo = $(this).closest('.form-group').find('.filtroSegundo');
            var $segundoSeleccionado = $(this).closest('.form-group').find('input[type="hidden"]');
            $filtroSegundo.val(nombreSegundo);
            $segundoSeleccionado.val(idSegundoAyudante);
            $(this).parent().empty();
        });

        $(document).on('click', function (event) {
            if (!$(event.target).closest('.opcion-segundo').length && !$(event.target).is('.filtroSegundo')) {
                $('.opcion-segundo').empty();
            }
        });
    }

    function addNewFields() {
        var $newFields = $('#field-container-cirujanos').clone();
        $newFields.attr('id', 'field-container-cirujanos-' + fieldIndex);

        // Iterate through inputs and other elements
        $newFields.find('input[type="text"], input[type="hidden"], div[class*="opcion"]').each(function() {
            var $this = $(this);
            var id = $this.attr('id');
            var name = $this.attr('name');

            // Ensure id and name exist before attempting to replace
            if (id) {
                var newId = id.replace('_0', '_' + fieldIndex);
                $this.attr('id', newId);
            } else {
                console.warn('ID attribute is missing on:', this);
            }

            if (name) {
                var newName = name.replace('_0', '_' + fieldIndex);
                $this.attr('name', newName);
            } else {
                console.warn('Name attribute is missing on:', this);
            }

            // Clear the value
            $this.val('');
        });

        // Update labels
        $newFields.find('.cirujanoLabel').text('Cirujano ' + (fieldIndex + 1)).css('background', 'white');
        $newFields.find('.primerAyudanteLabel').text('Primer ayudante ' + (fieldIndex + 1)).css('background', 'white');
        $newFields.find('.segundoAyudanteLabel').text('Segundo ayudante ' + (fieldIndex + 1)).css('background', 'white');

        // Remove 'required' attribute
        $newFields.find('input[type="text"]').removeAttr('required');

        // Append new fields
        $('#additional-fields-cirujanos').append($newFields);
        setupFieldEvents($newFields);

        fieldIndex++;
    }


    setupFieldEvents($('#field-container-cirujanos'));
});
//VERIFICAR QUE AL GUARDAR SE PASEN LOS DATOS


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
    let fieldIndex = 1;
    const maxFields = 3;

    function checkAndShowExtraFields() {
        if ($('.filtroMaterial').last().val() !== '') {
            if (fieldIndex < maxFields) {
                addNewFields();
            }
        }
    }

    function setupFieldEvents($container) {
        $container.find('.filtroMaterial').on('input', function () {
            checkAndShowExtraFields();
        });

        $container.find('.filtroMaterial').on('input', function () {
            var filtroMaterial = $(this).val();
            var $opcionesMaterial = $(this).next('.opcion-material');

            $.ajax({
                url: '/formulario/obtenerMaterialProtesico',
                method: 'GET',
                data: { filtroMaterial: filtroMaterial },
                success: function (data) {
                    $opcionesMaterial.empty();
                    $.each(data, function (index, option) {
                        var $opcion = $('<div class="opcion-material select-option" data-id="' + option.id + '">' + option.nombre + '</div>');
                        $opcionesMaterial.append($opcion);
                    });
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });
        });

        $container.on('click', '.opcion-material .select-option', function () {
            var nombreMaterial = $(this).text();
            var idMaterial = $(this).data('id');
            var $filtroMaterial = $(this).closest('.form-group').find('.filtroMaterial');
            var $materialSeleccionado = $(this).closest('.form-group').find('input[type="hidden"]');
            $filtroMaterial.val(nombreMaterial);
            $materialSeleccionado.val(idMaterial);
            $(this).parent().empty();
        });

        $(document).on('click', function (event) {
            if (!$(event.target).closest('.opcion-material').length && !$(event.target).is('.filtroMaterial')) {
                $('.opcion-material').empty();
            }
        });
    }

    function addNewFields() {
        var $newFields = $('#field-container-material').clone();
        $newFields.attr('id', 'field-container-material-' + fieldIndex);

        // Iterate through inputs and other elements
        $newFields.find('input[type="text"], input[type="hidden"], input[type="number"], div[class*="opcion"]').each(function () {
            var $this = $(this);
            var id = $this.attr('id');
            var name = $this.attr('name');

            if (id) {
                var newId = id.replace('_0', '_' + fieldIndex);
                $this.attr('id', newId);
            }

            if (name) {
                var newName = name.replace('_0', '_' + fieldIndex);
                $this.attr('name', newName);
            }

            $this.val('');
        });

        // Update labels
        $newFields.find('.materialLabel').text('Material Protesico Implementado ' + (fieldIndex + 1)).css('background', 'white');
        $newFields.find('.cantidadMaterialLabel').text('Cantidad material implementdo ' + (fieldIndex +1))
        $('#additional-fields-material').append($newFields);
        setupFieldEvents($newFields);

        fieldIndex++;
    }
    //Falta que guarde esto en bd

    setupFieldEvents($('#field-container-material'));
});





