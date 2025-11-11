$(document).ready(function() {
    // Inicializar Select2
    $('.select2').select2({
        placeholder: '-- Seleccione un paciente --',
        allowClear: true
    });

    // Cuando se selecciona un paciente
    $('#paciente_id').on('change', function() {
        const pacienteId = $(this).val();
        
        if (pacienteId) {
            cargarDatosPaciente(pacienteId);
        } else {
            ocultarDatosPaciente();
        }
    });

    // Cuando cambian los datos manuales
    $('#proteinas_g_kg, #porcentaje_grasas').on('input', function() {
        calcularMoleculaCalorica();
    });

    function cargarDatosPaciente(pacienteId) {
        $.ajax({
            url: `/molecula_calorica/get_paciente_data/${pacienteId}`,
            type: 'GET',
            success: function(response) {
                if (response.success) {
                    mostrarDatosPaciente(response);
                    $('#btn_submit').prop('disabled', false);
                } else {
                    mostrarError('Error al cargar datos del paciente');
                    $('#btn_submit').prop('disabled', true);
                }
            },
            error: function() {
                mostrarError('Error al cargar datos del paciente');
                $('#btn_submit').prop('disabled', true);
            }
        });
    }

    function mostrarDatosPaciente(data) {
        $('#paciente_nombre').text(data.paciente.nombre_completo);
        
        if (data.ultima_medida) {
            $('#ultimo_peso').text(data.ultima_medida.peso_kg);
            $('#ultima_talla').text(data.ultima_medida.talla_cm);
            $('#peso_kg').val(data.ultima_medida.peso_kg);
            $('#talla_cm').val(data.ultima_medida.talla_cm);
            $('#medida_id').val(data.ultima_medida.id);
        } else {
            $('#ultimo_peso').text('No disponible');
            $('#ultima_talla').text('No disponible');
        }

        if (data.ultimo_requerimiento) {
            $('#get_kcal').text(data.ultimo_requerimiento.get_kcal);
            $('#fecha_requerimiento').text(new Date(data.ultimo_requerimiento.calculado_en).toLocaleDateString());
            $('#kilocalorias_totales').val(data.ultimo_requerimiento.get_kcal);
            $('#requerimiento_id').val(data.ultimo_requerimiento.id);
        } else {
            $('#get_kcal').text('No disponible');
            $('#fecha_requerimiento').text('No disponible');
        }

        $('#paciente_data').show();
        calcularMoleculaCalorica();
    }

    function ocultarDatosPaciente() {
        $('#paciente_data').hide();
        $('#resultados_calculo').hide();
        $('#btn_submit').prop('disabled', true);
    }

    function calcularMoleculaCalorica() {
        const proteinasGkg = parseFloat($('#proteinas_g_kg').val()) || 0;
        const porcentajeGrasas = parseFloat($('#porcentaje_grasas').val()) || 0;
        const pesoKg = parseFloat($('#peso_kg').val()) || 0;
        const kcalTotales = parseFloat($('#kilocalorias_totales').val()) || 0;

        if (proteinasGkg > 0 && porcentajeGrasas > 0 && pesoKg > 0 && kcalTotales > 0) {
            // 1. Proteínas (gramos)
            const proteinasG = proteinasGkg * pesoKg;

            // 2. Kilocalorías de proteínas
            const kcalProteinas = proteinasG * 4;

            // 3. Porcentaje de proteínas
            const porcentajeProteina = kcalProteinas / kcalTotales;

            // 4. Kilocalorías de grasa
            const kcalGrasas = kcalTotales * porcentajeGrasas;

            // 5. Gramos de grasa
            const grasasG = kcalGrasas / 9;

            // 6. Porcentaje de carbohidratos
            const porcentajeCarbohidratos = 1 - (porcentajeProteina + porcentajeGrasas);

            // 7. Kilocalorías de carbohidratos
            const kcalCarbohidratos = kcalTotales * porcentajeCarbohidratos;

            // 8. Gramos de carbohidratos
            const carbohidratosG = kcalCarbohidratos / 4;

            // Mostrar resultados
            mostrarResultados({
                proteinas: {
                    porcentaje: (porcentajeProteina * 100).toFixed(1),
                    kcal: kcalProteinas.toFixed(2),
                    gramos: proteinasG.toFixed(2)
                },
                grasas: {
                    porcentaje: (porcentajeGrasas * 100).toFixed(1),
                    kcal: kcalGrasas.toFixed(2),
                    gramos: grasasG.toFixed(2)
                },
                carbohidratos: {
                    porcentaje: (porcentajeCarbohidratos * 100).toFixed(1),
                    kcal: kcalCarbohidratos.toFixed(2),
                    gramos: carbohidratosG.toFixed(2)
                }
            });

            // Llenar campos hidden
            $('#kilocalorias_proteinas').val(kcalProteinas);
            $('#kilocalorias_grasas').val(kcalGrasas);
            $('#kilocalorias_carbohidratos').val(kcalCarbohidratos);
            $('#porcentaje_proteinas').val(porcentajeProteina);
            $('#porcentaje_carbohidratos').val(porcentajeCarbohidratos);

        } else {
            $('#resultados_calculo').hide();
        }
    }

    function mostrarResultados(resultados) {
        $('#resultado_proteina_porcentaje').text(resultados.proteinas.porcentaje);
        $('#resultado_proteina_kcal').text(resultados.proteinas.kcal);
        $('#resultado_proteina_gramos').text(resultados.proteinas.gramos);

        $('#resultado_grasa_porcentaje').text(resultados.grasas.porcentaje);
        $('#resultado_grasa_kcal').text(resultados.grasas.kcal);
        $('#resultado_grasa_gramos').text(resultados.grasas.gramos);

        $('#resultado_carbohidrato_porcentaje').text(resultados.carbohidratos.porcentaje);
        $('#resultado_carbohidrato_kcal').text(resultados.carbohidratos.kcal);
        $('#resultado_carbohidrato_gramos').text(resultados.carbohidratos.gramos);

        $('#resultados_calculo').show();
    }

    function mostrarError(mensaje) {
        alert(mensaje);
    }
});