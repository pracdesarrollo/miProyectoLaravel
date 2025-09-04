<x-app-layout>
    <div class="container mx-auto p-4 bg-gray-100 min-h-screen" id="main-content">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold text-gray-800">Lista de Ventas</h1>
            @can('create sales')
                <a href="{{ route('sales.create') }}" class="mt-4 inline-block px-6 py-3 bg-blue-600 text-white rounded-lg">Crear Nueva Venta</a>
            @endcan
        </div>
        @if($sales->isEmpty())
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4" role="alert">
                <p class="font-bold">Aviso</p>
                <p>No hay ninguna venta registrada en su base de datos.</p>
            </div>
        @endif
        
        <form action="{{ route('sales.index') }}" method="GET">
            <div class="flex items-center space-x-4 mb-4">
                <div class="flex-grow">
                    <input type="text" name="query" placeholder="Buscar por Producto o Vendedor" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>
                <button class="bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 px-4 rounded">Buscar</button>
            </div>
        </form>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr class="bg-green-600 text-white uppercase text-sm font-semibold">
                        <th class="py-3 px-6 text-left">Folio</th>
                        <th class="py-3 px-6 text-left">Usuario</th>
                        <th class="py-3 px-6 text-left">Monto Total</th>
                        <th class="py-3 px-6 text-left">Fecha de Venta</th>
                        <th class="py-3 px-6 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    @foreach($sales as $sale)
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="py-3 px-6 text-left whitespace-nowrap">{{ $sale->id }}</td>
                            <td class="py-3 px-6 text-left">{{ $sale->user->name ?? 'Usuario no encontrado' }}</td>
                            <td class="py-3 px-6 text-left">Q{{ number_format($sale->total_price, 2) }}</td>
                            <td class="py-3 px-6 text-left">{{ \Carbon\Carbon::parse($sale->sale_date)->format('d/m/Y') }}</td>
                            <td class="py-3 px-6 text-center">
                                <div class="flex item-center justify-center space-x-2">
                                    <!-- Botón para ver detalles de la venta -->
                                    <a href="{{ route('sales.show', $sale->id) }}" class="w-6 h-6 transform hover:scale-110 text-gray-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>
                                    </a>
                                    
                                    <!-- Botón para imprimir recibo 
                                    <button onclick="showReceipt({{ $sale->id }})" class="w-6 h-6 transform hover:scale-110 text-gray-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-1.5a1.5 1.5 0 0 1 0-3m0 0a.75.75 0 0 0-.214-.525L6.15 8.19a.75.75 0 0 0-.525-.214H5.25A2.25 2.25 0 0 0 3 6v.75m3 2.25V6m0 0l-1.5-1.5M6 6H4.5m0 0l-1.5-1.5M18 18H9m-1.5 0H6.75A.75.75 0 0 1 6 17.25V13.5m0-1.5V12m0 0h.75m-1.5 0H4.5m0 0l-1.5-1.5M18 18v-1.5m0 0V15m0 0H9m-1.5 0H6.75A.75.75 0 0 1 6 14.25V10.5m0-1.5v-1.5m0 0h.75m-1.5 0H4.5m0 0l-1.5-1.5" />
                                        </svg>
                                    </button>-->
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Modal para el recibo -->
        <div id="receipt-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden justify-center items-center p-4">
            <div class="bg-white p-6 rounded-lg shadow-xl w-full max-w-lg overflow-y-auto max-h-[90vh]">
                <div class="flex justify-between items-center border-b pb-3 mb-4">
                    <h2 class="text-xl font-bold">Vista Previa de Recibo</h2>
                    <button onclick="closeReceiptModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <div id="receipt-content" class="text-gray-700 font-mono">
                    <!-- El contenido del recibo se cargará aquí dinámicamente -->
                </div>
                <div class="mt-4 flex justify-end space-x-2">
                    <button onclick="printReceipt()" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg">Imprimir Recibo</button>
                    <button onclick="closeReceiptModal()" class="bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 px-4 rounded-lg">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<!-- Coloca el script aquí, justo antes del cierre de <body> -->
<script>
    // Asigna los elementos del DOM a constantes para un acceso más fácil
    const receiptModal = document.getElementById('receipt-modal');
    const receiptContent = document.getElementById('receipt-content');
    const mainContent = document.getElementById('main-content');

    // Función para cerrar el modal del recibo
    function closeReceiptModal() {
        receiptModal.classList.add('hidden');
        receiptModal.classList.remove('flex');
    }

    // Función asíncrona para mostrar la vista previa del recibo
    async function showReceipt(saleId) {
        // Muestra un mensaje de carga y el modal
        receiptContent.innerHTML = '<p class="text-center text-gray-500">Cargando...</p>';
        receiptModal.classList.add('flex');
        receiptModal.classList.remove('hidden');

        try {
            // Realiza una solicitud fetch a la API para obtener los datos de la venta
            const response = await fetch(`/sales/${saleId}/receipt`);
            const data = await response.json();

            // Verifica si la respuesta es exitosa
            if (response.ok) {
                renderReceipt(data);
            } else {
                receiptContent.innerHTML = `<p class="text-center text-red-500">Error al cargar el recibo: ${data.message}</p>`;
            }
        } catch (error) {
            // Maneja errores de red
            receiptContent.innerHTML = '<p class="text-center text-red-500">Error de red. Por favor, revisa tu conexión.</p>';
        }
    }

    // Función para renderizar el contenido del recibo en el modal
    function renderReceipt(data) {
        let itemsHtml = '';
        let subtotal = 0;
        const ivaRate = 0.12; // Suponiendo un IVA del 12%

        // Itera sobre los productos para crear la lista de items
        data.products.forEach(item => {
            const itemTotal = item.pivot.quantity * item.pivot.price_at_sale;
            subtotal += itemTotal;
            itemsHtml += `
                <div class="flex justify-between items-center mb-1">
                    <span class="truncate pr-2">${item.name}</span>
                    <span class="flex-shrink-0">Q${item.pivot.price_at_sale} x ${item.pivot.quantity}</span>
                    <span class="flex-shrink-0">Q${itemTotal.toFixed(2)}</span>
                </div>
            `;
        });

        // Calcula el IVA y el total final
        const ivaAmount = subtotal * ivaRate;
        const total = subtotal + ivaAmount;

        // Genera el HTML completo del recibo
        const htmlContent = `
            <div class="text-sm">
                <h3 class="font-bold text-center text-lg mb-2">Comprobante de Venta</h3>
                <hr class="border-gray-400 my-2">
                <p><strong>Folio Venta:</strong> #${data.id}</p>
                <p><strong>Fecha:</strong> ${new Date(data.sale_date).toLocaleDateString()}</p>
                <p><strong>Usuario:</strong> ${data.user.name}</p>
                <hr class="border-gray-400 my-2">
                <p class="font-bold">Detalle de Productos:</p>
                ${itemsHtml}
                <hr class="border-gray-400 my-2">
                <div class="flex justify-between font-bold">
                    <span>Subtotal:</span>
                    <span>Q${subtotal.toFixed(2)}</span>
                </div>
                <div class="flex justify-between font-bold">
                    <span>IVA:</span>
                    <span>Q${ivaAmount.toFixed(2)}</span>
                </div>
                <div class="flex justify-between font-bold text-lg">
                    <span>Total:</span>
                    <span>Q${total.toFixed(2)}</span>
                </div>
                <hr class="border-gray-400 my-2">
                <p class="text-center mt-4">¡Gracias por tu compra!</p>
            </div>
        `;
        receiptContent.innerHTML = htmlContent;
    }

    // Función para imprimir el recibo de manera más robusta
    function printReceipt() {
        const originalContent = document.body.innerHTML;
        const receiptContentToPrint = `
            <style>
                body { font-family: sans-serif; padding: 24px; }
                .receipt-container { max-width: 500px; margin: auto; }
                @media print {
                    body {
                        font-size: 10pt;
                    }
                    .receipt-container {
                        width: 100%;
                    }
                }
            </style>
            <div class="receipt-container">${receiptContent.innerHTML}</div>
        `;
        document.body.innerHTML = receiptContentToPrint;
        window.print();
        document.body.innerHTML = originalContent;
    }
</script>
