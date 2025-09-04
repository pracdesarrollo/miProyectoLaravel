<x-app-layout>
    <div class="container mx-auto p-4 bg-gray-100 min-h-screen">
        <div class="bg-white rounded-lg shadow-xl p-8 w-full max-w-2xl mx-auto">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Detalles de la Venta #{{ $sale->id }}</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="font-bold text-lg text-gray-700 mb-2">Información de la Venta</h3>
                    <div class="mb-4">
                        <p class="font-bold text-gray-700">Folio:</p>
                        <p class="text-gray-900">{{ $sale->id }}</p>
                    </div>
                    <div class="mb-4">
                        <p class="font-bold text-gray-700">Vendedor:</p>
                        <p class="text-gray-900">{{ $sale->user->name ?? 'N/A' }} {{ $sale->user->last_name ?? '' }}</p>
                    </div>
                    <div class="mb-4">
                        <p class="font-bold text-gray-700">Monto Total:</p>
                        <p class="text-gray-900">Q{{ number_format($sale->total_price, 2) }}</p>
                    </div>
                    <div class="mb-4">
                        <p class="font-bold text-gray-700">Fecha de Venta:</p>
                        <p class="text-gray-900">{{ \Carbon\Carbon::parse($sale->sale_date)->format('d/m/Y H:i:s') }}</p>
                    </div>
                </div>

                <div>
                    <h3 class="font-bold text-lg text-gray-700 mb-2">Productos Vendidos</h3>
                    <div class="bg-gray-100 p-4 rounded-md">
                        @foreach($sale->products as $product)
                            <div class="mb-4 border-b pb-4 last:border-b-0 last:pb-0">
                                <div class="mb-2">
                                    <span class="font-semibold">Nombre del producto:</span>
                                    <p class="text-gray-900">{{ $product->name }}</p>
                                </div>
                                <div class="mb-2">
                                    <span class="font-semibold">Cantidad:</span>
                                    <p class="text-gray-900">{{ $product->pivot->quantity }}</p>
                                </div>
                                <div>
                                    <span class="font-semibold">Precio unitario:</span>
                                    <p class="text-gray-900">Q{{ number_format($product->pivot->price_at_sale, 2) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <a href="{{ route('sales.index') }}" class="mt-8 inline-block px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-300">Regresar a la lista</a>
        </div>
    </div>
</x-app-layout>
