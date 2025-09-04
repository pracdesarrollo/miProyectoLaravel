<x-app-layout>
    <div class="container mx-auto p-4 bg-gray-100 min-h-screen">
        <div class="bg-white rounded-lg shadow-2xl p-8 w-full max-w-2xl mx-auto">
            <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">💊 Registrar Nueva Venta</h2>

            @if (session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md" role="alert">
                    <p class="font-bold">Error en la venta</p>
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            <form action="{{ route('sales.store') }}" method="POST">
                @csrf
                
                <div class="mb-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Folio</label>
                        <input type="text" value="{{ ($lastSaleId ?? 0) + 1 }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 bg-gray-200 leading-tight" disabled>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Vendedor</label>
                        <input type="text" value="{{ Auth::user()->name }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 bg-gray-200 leading-tight" disabled>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Fecha y Hora</label>
                        <input type="text" id="sale_date_display" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 bg-gray-200 leading-tight" disabled>
                        <input type="hidden" id="sale_datetime" name="sale_datetime">
                    </div>
                </div>

                <div id="products-container" class="space-y-6 mb-6">
                    <div class="product-row grid grid-cols-1 md:grid-cols-4 gap-4 p-4 border-b border-gray-200 last:border-b-0">
                        <div class="col-span-2">
                            <label class="block text-gray-700 text-sm font-semibold mb-2">Producto</label>
                            <select name="products[0][product_id]" class="product-select shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                <option value="" disabled selected>Selecciona un producto</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-semibold mb-2">Cantidad</label>
                            <input type="number" name="products[0][quantity]" class="quantity-input shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" min="1" value="1" required>
                        </div>
                        <div class="flex items-end justify-between">
                            <span class="price-display text-lg font-bold text-gray-800">$0.00</span>
                            <button type="button" class="remove-product-btn text-red-500 hover:text-red-700 font-bold text-sm px-2 py-1 transition-colors duration-300">
                                ❌
                            </button>
                        </div>
                    </div>
                </div>

                <div class="flex justify-between items-center mb-6">
                    <button type="button" id="add-product-btn" class="bg-indigo-600 text-white font-bold py-2 px-4 rounded-full shadow-lg hover:bg-indigo-700 transition-colors duration-300 transform hover:scale-105">
                        ➕ Agregar Producto
                    </button>
                    <span class="text-xl font-bold text-gray-800">Total: <span id="total-price">$0.00</span></span>
                </div>
                
                <div class="flex justify-center mt-8">
                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-full text-lg transition-colors duration-300 transform hover:scale-105">
                        Registrar Venta
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const productsContainer = document.getElementById('products-container');
        const addProductBtn = document.getElementById('add-product-btn');
        const totalDisplay = document.getElementById('total-price');
        const saleDatetimeInput = document.getElementById('sale_datetime');
        const saleDateDisplay = document.getElementById('sale_date_display');
        let productIndex = 1;

        function updateDateTime() {
            const now = new Date();
            const localDate = now.toLocaleString('es-MX', {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: false
            });
            saleDateDisplay.value = localDate;
            saleDatetimeInput.value = now.toISOString().slice(0, 19).replace('T', ' ');
        }
        updateDateTime();

        function updateTotalPrice() {
            let total = 0;
            document.querySelectorAll('.product-row').forEach(row => {
                const select = row.querySelector('.product-select');
                const price = parseFloat(select.options[select.selectedIndex]?.dataset.price || 0);
                const quantity = parseInt(row.querySelector('.quantity-input').value, 10) || 0;
                const rowTotal = price * quantity;
                row.querySelector('.price-display').textContent = `$${rowTotal.toFixed(2)}`;
                total += rowTotal;
            });
            totalDisplay.textContent = `$${total.toFixed(2)}`;
        }

        addProductBtn.addEventListener('click', function () {
            const firstProductRow = productsContainer.firstElementChild;
            const newProductRow = firstProductRow.cloneNode(true);
            
            newProductRow.querySelector('.product-select').name = `products[${productIndex}][product_id]`;
            newProductRow.querySelector('.quantity-input').name = `products[${productIndex}][quantity]`;
            
            newProductRow.querySelector('.product-select').selectedIndex = 0;
            newProductRow.querySelector('.quantity-input').value = 1;
            newProductRow.querySelector('.price-display').textContent = '$0.00';

            newProductRow.querySelector('.remove-product-btn').addEventListener('click', function() {
                newProductRow.remove();
                updateTotalPrice();
            });

            productsContainer.appendChild(newProductRow);
            productIndex++;
            updateTotalPrice();
        });

        productsContainer.addEventListener('change', function (e) {
            if (e.target.classList.contains('product-select') || e.target.classList.contains('quantity-input')) {
                updateTotalPrice();
            }
        });

        productsContainer.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-product-btn')) {
                e.target.closest('.product-row').remove();
                updateTotalPrice();
            }
        });
        
        // Initial calculation on page load
        updateTotalPrice();
    });
</script>
