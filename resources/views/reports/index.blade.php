<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-2 text-center md:text-left print-title">Generar Reporte de Ventas</h1>
        <p class="print-hide text-gray-600 mb-6 text-center md:text-left">Filtra las ventas por período para generar un reporte.</p>
    
        <div class="bg-white rounded-lg shadow-md p-6 mb-8 max-w-4xl mx-auto">
            <form id="filtro-form" class="flex flex-col md:flex-row md:items-end md:space-x-4">
                
                <div class="flex-1 mb-4 md:mb-0">
                    <label for="start_date" class="block text-gray-700 font-semibold mb-2 text-sm">Desde</label>
                    <input type="date" id="start_date" name="start_date" class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline text-sm">
                </div>

                <div class="flex-1 mb-4 md:mb-0">
                    <label for="end_date" class="block text-gray-700 font-semibold mb-2 text-sm">Hasta</label>
                    <input type="date" id="end_date" name="end_date" class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline text-sm">
                </div>

                <div class="w-full md:w-auto">
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-300">
                        Generar Reporte
                    </button>
                </div>
            </form>
        </div>
        
        <div id="loading-message" class="hidden text-center mt-8">
            <p class="text-gray-500 animate-pulse">Cargando datos...</p>
        </div>

        <div id="reporte-container" class="hidden mt-8 max-w-4xl mx-auto">
            <div id="reporte-content"></div>
        </div>

        <div id="exportar-botones" class="mt-6 flex flex-col md:flex-row md:justify-end md:space-x-4 hidden max-w-4xl mx-auto">
            <button id="imprimir-btn" class="print-hide mb-4 md:mb-0 bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-300">
                Imprimir Reporte
            </button>
            <button id="generar-excel-btn" class=" print-hide mb-4 md:mb-0 bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-300">
                Convertir a Excel
            </button>
            <a href="#" id="generar-pdf-btn" class="print-hide bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-300">
                Convertir a PDF
            </a>
        </div>
    </div>

    <style>
        @media print {
            .print-hide {
                display: none !important;
            }
            .print-title {
                text-align: center !important;
                font-size: 2rem !important;
                margin-bottom: 2rem !important;
            }
            #reporte-container {


                display: block !important;
                margin: 0 auto !important;
                padding: 0 !important;
                box-shadow: none !important;
                width: 100% !important;
            }
            body {
                margin: 0;
                padding: 0;
            }
            #tabla-reporte {
                width: 100% !important; 
                table-layout: fixed; 
                transform: scale(0.85);
                transform-origin: top left;
            }
            #tabla-reporte td,
            #tabla-reporte th {
                white-space: normal !important; 
                word-wrap: break-word !important; 
                word-break: break-all !important;
                padding: 2px 4px !important;
                font-size: 8px !important;
            }
        }
        #tabla-reporte {
            min-width: 100%;
            table-layout: auto;
        }
        .overflow-x-auto {
            overflow-x: auto;
        }
    </style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const filtroForm = document.getElementById('filtro-form');
        const reporteContainer = document.getElementById('reporte-container');
        const reporteContent = document.getElementById('reporte-content');
        const exportarBotones = document.getElementById('exportar-botones');
        const loadingMessage = document.getElementById('loading-message');

        filtroForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const startDateInput = document.getElementById('start_date').value;
            const endDateInput = document.getElementById('end_date').value;
            if (!startDateInput || !endDateInput) {
                displayErrorMessage("Debes elegir las fechas de las cuales deseas el reporte.");
                return;
            }
            reporteContainer.classList.add('hidden');
            exportarBotones.classList.add('hidden');
            loadingMessage.classList.remove('hidden');

            const formData = new FormData();
            formData.append('start_date', startDateInput);
            formData.append('end_date', endDateInput);
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            if (csrfToken) {
                formData.append('_token', csrfToken);
            }

            try {
                const response = await fetch('{{ route('reports.generate_api') }}', {
                    method: 'POST',
                    body: formData
                });
                const responseData = await response.json();
                loadingMessage.classList.add('hidden');
                
                if (response.ok && responseData.status === 'success') {
                    const salesData = responseData.sales;
                    if (salesData.length > 0) {
                        displayReport(salesData, responseData.startDate, responseData.endDate);
                        exportarBotones.classList.remove('hidden');
                    } else {
                        displayNoSalesMessage();
                        exportarBotones.classList.add('hidden');
                    }
                } else {
                    console.error('Error HTTP:', response.status, response.statusText);
                    displayErrorMessage('Hubo un error al conectar con el servidor. Por favor, verifica tu API.');
                }
            } catch (error) {
                console.error("Error de red:", error);
                loadingMessage.classList.add('hidden');
                displayErrorMessage('Hubo un error de red. Por favor, revisa tu conexión a internet.');
            }
        });

        function displayReport(sales, startDate, endDate) {
            let totalSales = 0;
            const tableRows = sales.map(sale => {
                const totalPrice = parseFloat(sale.total_price.replace(',', ''));
                totalSales += totalPrice;

                return `
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">${sale.sale_date}</td>
                        <td class="px-6 py-4 whitespace-nowrap">${sale.product_name}</td>
                        <td class="px-6 py-4 whitespace-nowrap">${sale.quantity}</td>
                        <td class="px-6 py-4 whitespace-nowrap">${sale.unit_price}</td>
                        <td class="px-6 py-4 whitespace-nowrap">${totalPrice.toFixed(2)}</td>
                    </tr>
                `;
            }).join('');

            const reportHtml = `
                <div id="reporte-contenido-para-pdf" class="bg-white rounded-lg shadow-md p-6">
                    <div class="text-center mb-4">
                        <h3 class="text-2xl font-bold text-gray-800">Reporte de Ventas</h3>
                        <p class="text-gray-600">${startDate} al ${endDate}</p>
                    </div>
                    <div class="overflow-x-auto">
                        <table id="tabla-reporte" class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr class="bg-gray-100 font-bold">
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Producto</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cantidad</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio Unitario</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total de Venta</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                ${tableRows}
                                <tr class="bg-gray-100 font-bold">
                                    <td colspan="4" class="px-6 py-4 text-right">Total del Reporte:</td>
                                    <td class="px-6 py-4 whitespace-nowrap">${totalSales.toFixed(2)}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            `;
            reporteContent.innerHTML = reportHtml;
            reporteContainer.classList.remove('hidden');
        }

        function displayNoSalesMessage() {
            reporteContent.innerHTML = `
                <div class="bg-white rounded-lg shadow-md p-6 text-center">
                    <p class="text-gray-500">No hubo ventas en el rango de fechas seleccionado.</p>
                </div>
            `;
            reporteContainer.classList.remove('hidden');
        }

        function displayErrorMessage(message) {
            const reporteContainer = document.getElementById('reporte-container');
            const reporteContent = document.getElementById('reporte-content');
            const exportarBotones = document.getElementById('exportar-botones');
            reporteContent.innerHTML = `
                <div class="bg-white rounded-lg shadow-md p-6 text-center">
                    <p class="text-red-500">${message}</p>
                </div>
            `;
            reporteContainer.classList.remove('hidden');
            exportarBotones.classList.add('hidden');
        }

        // Event listener for client-side PDF generation
        document.getElementById('generar-pdf-btn').addEventListener('click', async (e) => {
    e.preventDefault();

    const element = document.getElementById('reporte-contenido-para-pdf');
    if (!element) return;

    // Clona el nodo y lo limpia
    const cloned = element.cloneNode(true);
    cloned.style.margin = '0';
    cloned.style.padding = '0';
    cloned.style.boxShadow = 'none';
    cloned.style.background = '#fff';
    cloned.style.width = '100%';
    cloned.style.maxWidth = '100%';

    // Opcional: centrar texto y ajustar título
    const title = cloned.querySelector('h3');
    if (title) {
        title.style.marginTop = '0';
        title.style.textAlign = 'center';
    }

    const opt = {
        margin:       [10, 10, 10, 10],
        filename:     'reporte_de_ventas.pdf',
        image:        { type: 'jpeg', quality: 0.98 },
        html2canvas:  { scale: 2, scrollY: 0 },
        jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' },
        pagebreak:    { mode: ['avoid-all', 'css', 'legacy'] }
    };

    await html2pdf().set(opt).from(cloned).save();
});


        document.getElementById('generar-excel-btn').addEventListener('click', () => {
            const tablaReporte = document.getElementById('tabla-reporte');
            if (!tablaReporte) return;
            let csv = ["Fecha,Producto,Cantidad,Precio Unitario,Total de Venta"];
            const rows = tablaReporte.querySelectorAll('tbody tr');
            rows.forEach(row => {
                let rowData = [];
                const cells = row.querySelectorAll('td');
                if (cells[0] && cells[0].innerText.trim() === 'Total del Reporte:') {
                    return;
                }
                cells.forEach(cell => {
                    let cellText = cell.innerText.trim();
                    cellText = cellText.replace(/"/g, '""');
                    if (cellText.includes(',')) {
                        cellText = `"${cellText}"`;
                    }
                    rowData.push(cellText);
                });
                csv.push(rowData.join(','));
            });
            const totalRow = tablaReporte.querySelector('tbody tr:last-child');
            if (totalRow) {
                let totalText = "Total del Reporte:," + totalRow.querySelector('td:last-child').innerText.trim();
                csv.push(totalText);
            }
            const csvString = csv.join('\n');
            const blob = new Blob([csvString], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.setAttribute('download', 'reporte_de_ventas.csv');
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        });

        document.getElementById('imprimir-btn').addEventListener('click', () => {
            window.print();
        });
    });
</script>
</x-app-layout>