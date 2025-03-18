$(document).ready(function () {
    // Manejo de la carga de archivo
    $('#uploadForm').on('submit', function (e) {
        e.preventDefault();  // Evitar la recarga de página

        const fileInput = $('#fileInput')[0].files[0];  // Obtener el archivo seleccionado
        if (!fileInput) {
            alert('Por favor selecciona un archivo.');  // Verificar que se haya seleccionado un archivo
            return;
        }

        const formData = new FormData();  // Crear FormData para el archivo
        formData.append('file', fileInput);  // Agregar el archivo al FormData

        $('#tableContainer').html('<p class="text-center text-secondary">Cargando archivo...</p>');  // Mensaje de carga

        // Enviar el archivo al servidor usando AJAX
        $.ajax({
            url: '/upload',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.success) {
                    $('#tableContainer').html(`
                        <h3 class="mt-4">Tabla Original</h3>
                        <div class="table-container">${response.table_html}</div>
                    `);
                    $('#filterButton').show();  // Mostrar el botón de filtrado después de cargar el archivo
                    $('#totalPackages').text(response.totalPackages);
                } else {
                    alert(response.message);
                }
            },
            error: function () {
                alert('Error al cargar el archivo.');
            }
        });
    });

    // Filtrar por peso (se ejecuta después de que se haya cargado el archivo)
    $('#filterButton').on('click', function () {
        const weight = $('#filterWeight').val();
        if (!weight || isNaN(weight)) {
            alert('Por favor ingresa un peso válido.');
            return;
        }

        $('#tableContainer').html('<p class="text-center text-secondary">Filtrando registros...</p>');

        $.ajax({
            url: '/filter',
            method: 'GET',
            data: { weight: weight },
            success: function (response) {
                if (response.success) {
                    $('#tableContainer').html(`
                        <h3 class="mt-4 text-success">Registros Filtrados (Peso > ${weight} Kg)</h3>
                        <div class="table-container">${response.filtered_table_html}</div>
                    `);
                    $('#totalPackages').text(response.filteredPackages);
                    $('#filterTimestamp').text(new Date().toLocaleString());
                } else {
                    alert(response.message);
                }
            },
            error: function () {
                alert('Error al filtrar los registros.');
            }
        });
    });

    // Descargar en Excel
    $('#downloadExcel').on('click', function () {
        const table = $('#tableContainer').find('table')[0];
        const wb = XLSX.utils.table_to_book(table, { sheet: "Paquetes" });
        XLSX.writeFile(wb, 'Paquetes.xlsx');
    });

    // Descargar en PDF
    $('#downloadPDF').on('click', function () {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();
        doc.html($('#tableContainer').find('table')[0], {
            callback: function (doc) {
                doc.save('Paquetes.pdf');
            },
            margin: [20, 20, 20, 20],
            autoPaging: true
        });
    });
});
