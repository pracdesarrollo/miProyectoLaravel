<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-2">Dashboard Administrador</h1>
        <p class="text-gray-600 mb-6">Panel de control completo del sistema</p>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            {{-- Tarjeta de Total Productos --}}
            <div class="bg-blue-600 text-white rounded-lg p-6 shadow-lg flex items-center justify-between">
                <div>
                    <h5 class="text-lg font-semibold">Total Productos</h5>
                    <h2 class="text-4xl font-bold mt-2">{{ $totalProducts }}</h2>
                </div>
                <div class="self-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                    </svg>
                </div>
            </div>

            {{-- Tarjeta de Total Usuarios --}}
            <div class="bg-green-600 text-white rounded-lg p-6 shadow-lg flex items-center justify-between">
                <div>
                    <h5 class="text-lg font-semibold">Total Usuarios</h5>
                    <h2 class="text-4xl font-bold mt-2">{{ $totalUsers }}</h2>
                </div>
                <div class="self-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>
                </div>
            </div>

            {{-- Tarjeta de Ventas Hoy --}}
            <div class="bg-cyan-600 text-white rounded-lg p-6 shadow-lg flex items-center justify-between">
                <div>
                    <h5 class="text-lg font-semibold">Ventas Hoy</h5>
                    <h2 class="text-4xl font-bold mt-2">${{ number_format($todaySales, 2) }}</h2>
                </div>
                <div class="self-center">
                   <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941" />
                    </svg>
                </div>
            </div>

            {{-- Tarjeta de Stock Bajo --}}
            <div class="bg-yellow-500 text-white rounded-lg p-6 shadow-lg flex items-center justify-between">
                <div>
                    <h5 class="text-lg font-semibold">Stock Bajo</h5>
                    <h2 class="text-4xl font-bold mt-2">{{ $lowStockCount }}</h2>
                </div>
                <div class="self-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            {{-- Tarjeta de Productos con Stock Bajo --}}
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between mb-4 border-b pb-4">
                    <h5 class="text-xl font-semibold">Productos con Stock Bajo</h5>
                    <a href="{{ route('products.low-stock') }}" class="px-4 py-2 text-sm font-semibold rounded-lg border border-gray-300 text-blue-600 hover:text-white hover:bg-blue-600 transition-colors duration-300">Ver Todos</a>
                </div>
                <div class="space-y-4">
                    @forelse($lowStockProducts as $product)
                        <div class="flex items-center justify-between py-2 border-b border-gray-200 last:border-b-0">
                            <div>
                                <strong class="text-lg">{{ $product->name }}</strong>
                                <p class="text-sm text-gray-500">{{ $product->category }}</p>
                            </div>
                            <span class="px-3 py-1 text-sm font-semibold rounded-full bg-yellow-400 text-gray-800">{{ $product->stock }} unidades</span>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center">No hay productos con stock bajo</p>
                    @endforelse
                </div>
            </div>

            {{-- Tarjeta de Ventas Recientes --}}
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between mb-4 border-b pb-4">
                    <h5 class="text-xl font-semibold">Ventas Recientes</h5>
                    <a href="#" class="px-4 py-2 text-sm font-semibold rounded-lg border border-gray-300 text-blue-600 hover:text-white hover:bg-blue-600 transition-colors duration-300">Ver Todas</a>
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
                        <p class="text-gray-500 text-center">No hay ventas registradas</p>
                    @endforelse
                </div>
            </div>
        </div>

        <h4 class="text-2xl font-semibold mb-4">Accesos Rápidos</h4>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-4">
            
            {{-- Botón Nuevo Producto --}}
            <a href="{{ route('products.create') }}" class="group bg-white p-6 rounded-lg shadow-md flex flex-col items-center justify-center text-center transition-all duration-300 hover:bg-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span class="text-lg font-semibold text-gray-700 group-hover:text-white">Nuevo Producto</span>
            </a>

            {{-- Botón Nuevo Usuario --}}
            <a href="{{ route('users.create') }}" class="group bg-white p-6 rounded-lg shadow-md flex flex-col items-center justify-center text-center transition-all duration-300 hover:bg-green-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                </svg>
                <span class="text-lg font-semibold text-gray-700 group-hover:text-white">Nuevo Usuario</span>
            </a>
            
            {{-- Botón Nueva Venta --}}
            <a href="#" class="group bg-white p-6 rounded-lg shadow-md flex flex-col items-center justify-center text-center transition-all duration-300 hover:bg-cyan-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span class="text-lg font-semibold text-gray-700 group-hover:text-white">Nueva Venta</span>
            </a>

            {{-- Botón Ver Productos --}}
            <a href="#" class="group bg-white p-6 rounded-lg shadow-md flex flex-col items-center justify-center text-center transition-all duration-300 hover:bg-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
                <span class="text-lg font-semibold text-gray-700 group-hover:text-white">Ver Productos</span>
            </a>

            {{-- Botón Reportes --}}
            <a href="{{ route('sales.reports') }}" class="group bg-white p-6 rounded-lg shadow-md flex flex-col items-center justify-center text-center transition-all duration-300 hover:bg-yellow-500">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5" />
                </svg>
                <span class="text-lg font-semibold text-gray-700 group-hover:text-white">Reportes</span>
            </a>

            {{-- Botón Stock Bajo --}}
            <a href="{{ route('products.low-stock') }}" class="group bg-white p-6 rounded-lg shadow-md flex flex-col items-center justify-center text-center transition-all duration-300 hover:bg-red-600">
               <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                 <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
               </svg>
                <span class="text-lg font-semibold text-gray-700 group-hover:text-white">Stock Bajo</span>
            </a>
        </div>
    </div>
</x-app-layout>