<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        @if (auth()->user()->hasRole('admin'))
            <h1 class="text-3xl font-bold mb-2">Dashboard Administrador</h1>
            <p class="text-gray-600 mb-6">Panel de control completo del sistema</p>

            {{-- Tarjetas de estadisticas del administrador --}}
            {{-- Asegúrate de que las variables como $totalProducts están definidas en tu controlador --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-blue-600 text-white rounded-lg p-6 shadow-lg">
                    <h5 class="text-lg font-semibold">Total Productos</h5>
                    <h2 class="text-4xl font-bold mt-2">{{ $totalProducts }}</h2>
                </div>
                <div class="bg-green-600 text-white rounded-lg p-6 shadow-lg">
                    <h5 class="text-lg font-semibold">Total Usuarios</h5>
                    <h2 class="text-4xl font-bold mt-2">{{ $totalUsers }}</h2>
                </div>
                <div class="bg-cyan-600 text-white rounded-lg p-6 shadow-lg">
                    <h5 class="text-lg font-semibold">Ventas Hoy</h5>
                    <h2 class="text-4xl font-bold mt-2">${{ number_format($todaySales, 2) }}</h2>
                </div>
                <div class="bg-yellow-500 text-white rounded-lg p-6 shadow-lg">
                    <h5 class="text-lg font-semibold">Stock Bajo</h5>
                    <h2 class="text-4xl font-bold mt-2">{{ $lowStockCount }}</h2>
                </div>
            </div>

            {{-- Tarjetas de listas de administrador --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h5 class="text-xl font-semibold">Productos con Stock Bajo</h5>
                    @forelse($lowStockProducts as $product)
                        <div><strong class="text-lg">{{ $product->name }}</strong></div>
                    @empty
                        <p>No hay productos con stock bajo</p>
                    @endforelse
                </div>
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h5 class="text-xl font-semibold">Ventas Recientes</h5>
                    @forelse($recentSales as $sale)
                        <div><strong class="text-lg">{{ $sale->product->name ?? 'Eliminado' }}</strong></div>
                    @empty
                        <p>No hay ventas registradas</p>
                    @endforelse
                </div>
            </div>
            {{-- Acceso las funciones del Admin --}}
            <div class="flex flex-wrap gap-4 mt-4 justify-center">
                @can('create users')
                    <a href="{{ route('users.index') }}" class="mt-4 inline-block px-6 py-3 bg-blue-600 text-white rounded-lg">Gestio de Usuarios</a>
                @endcan
                @can('create sales')
                    <a href="{{ route('sales.index') }}" class="mt-4 inline-block px-6 py-3 bg-blue-600 text-white rounded-lg">Gestios de Ventas</a>
                @endcan
                @can('create products')
                    <a href="{{ route('products.index') }}" class="mt-4 inline-block px-6 py-3 bg-blue-600 text-white rounded-lg">Gestion de Productos</a>
                @endcan
                @can('generate reports')
                    <a href="{{ route('reports.index') }}" class="mt-4 inline-block px-6 py-3 bg-blue-600 text-white rounded-lg">Gestión de Reporte</a>
                @endcan
            </div>
            



        @elseif (auth()->user()->hasRole('gerente'))
            <h1 class="text-3xl font-bold mb-2">Dashboard Gerente</h1>
            <p class="text-gray-600 mb-6">Panel de gestión y reportes</p>

            {{-- El gerente tiene acceso a ver todos los productos, como lo definiste en los permisos --}}
            @can('view products')
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h5 class="text-xl font-semibold">Todos los Productos</h5>
                    {{-- Aquí va el bucle para mostrar la lista de productos --}}
                    @forelse($products as $product)
                        <div><strong class="text-lg">{{ $product->name }}</strong></div>
                    @empty
                        <p>No hay productos registrados</p>
                    @endforelse
                </div>
            @endcan

            {{-- El gerente puede agregar nuevos usuarios --}}
            
            {{-- Acceso las funciones del Gerente --}}
            <div class="flex flex-wrap gap-4 mt-4 justify-center">
                @can('create users')
                    <a href="{{ route('users.index') }}" class="mt-4 inline-block px-6 py-3 bg-blue-600 text-white rounded-lg">Gestio de Usuarios</a>
                @endcan
                @can('create sales')
                    <a href="{{ route('sales.index') }}" class="mt-4 inline-block px-6 py-3 bg-blue-600 text-white rounded-lg">Gestios de Ventas</a>
                @endcan
                @can('view products')
                    <a href="{{ route('products.index') }}" class="mt-4 inline-block px-6 py-3 bg-blue-600 text-white rounded-lg">Gestion de Productos</a>
                @endcan
                @can('generate reports')
                    <a href="{{ route('reports.index') }}" class="mt-4 inline-block px-6 py-3 bg-blue-600 text-white rounded-lg">Gestión de Reporte</a>
                @endcan
            </div>
            

        @elseif (auth()->user()->hasRole('vendedor'))
            <h1 class="text-3xl font-bold mb-2">Dashboard Vendedor</h1>
            <p class="text-gray-600 mb-6">Gestión de tus ventas</p>

            {{-- El vendedor solo ve sus ventas recientes y la lista de productos --}}
            <div class="bg-white rounded-lg shadow-md p-6">
                <h5 class="text-xl font-semibold">Mis Ventas Recientes</h5>
                @forelse($recentSales as $sale)
                    <div><strong class="text-lg">{{ $sale->product->name ?? 'Eliminado' }}</strong></div>
                @empty
                    <p>No has registrado ventas aún</p>
                @endforelse
            </div>
            {{-- Acceso las funciones del Vendedor --}}
            <div class="flex flex-wrap gap-4 mt-4 justify-center">
                @can('view products')
                    <a href="{{ route('products.index') }}" class="mt-4 inline-block px-6 py-3 bg-blue-600 text-white rounded-lg">Gestio de Productos</a>
                @endcan
                @can('create sales')
                    <a href="{{ route('sales.index') }}" class="mt-4 inline-block px-6 py-3 bg-blue-600 text-white rounded-lg">Gestios de Ventas</a>
                @endcan
                
            </div>
            
        @endif
    </div>
</x-app-layout>