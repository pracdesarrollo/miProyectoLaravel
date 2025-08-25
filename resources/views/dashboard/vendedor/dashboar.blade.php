<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="flex items-center justify-center mt-12">
            <div class="bg-white rounded-lg p-8 shadow-sm max-w-2xl w-full text-center">
                <h1 class="text-4xl font-bold mb-3 text-gray-800">Bienvenido, Vendedor</h1>
                <p class="text-lg text-gray-600">Desde aquí podrás gestionar tus ventas y productos.</p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mt-6">
                    <a href="#" class="w-full sm:w-auto px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-colors duration-300">
                        <i class="bi bi-cart-plus me-2"></i>Registrar Nueva Venta
                    </a>
                    <a href="#" class="w-full sm:w-auto px-6 py-3 bg-gray-200 text-gray-800 rounded-lg font-semibold hover:bg-gray-300 transition-colors duration-300">
                        <i class="bi bi-list-ul me-2"></i>Ver Productos
                    </a>
                </div>
            </div>
        </div>

        {{-- Lista de ventas del vendedor --}}
        <div class="mt-8">
            <div class="bg-white rounded-lg p-6 shadow-sm">
                <div class="flex items-center justify-between mb-4 border-b pb-4">
                    <h5 class="text-xl font-semibold">Mis Ventas Recientes</h5>
                    <a href="#" class="px-4 py-2 text-sm font-semibold rounded-lg border border-gray-300 text-blue-600 hover:text-white hover:bg-blue-600 transition-colors duration-300">Ver Todas Mis Ventas</a>
                </div>
                <div class="space-y-4">
                    @forelse($recentSales as $sale)
                        <div class="flex items-center justify-between py-2 border-b border-gray-200 last:border-b-0">
                            <div>
                                <strong class="text-lg">{{ $sale->product->name ?? 'Producto eliminado' }}</strong>
                                <p class="text-sm text-gray-500">
                                    {{ $sale->user->full_name ?? 'Sin usuario' }} - {{ $sale->sale_date->format('d/m/Y H:i') }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-600">{{ $sale->quantity }} x ${{ number_format($sale->product->price ?? 0, 2) }}</p>
                                <strong class="text-xl text-green-600">${{ number_format($sale->total_price, 2) }}</strong>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center">No has registrado ventas aún.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>