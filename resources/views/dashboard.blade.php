<x-app-layout>

{{-- Si el usuario es administrador, muestra el dashboard completo --}}
@if(auth()->user()->isAdmin())
    <div class="row">
        <!-- Estadísticas Generales -->
        <div class="col-md-3 mb-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="card-title">Total Productos</h5>
                            <h2 class="mb-0">{{ App\Models\Product::count() }}</h2>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-box fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="col-md-3 mb-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="card-title">Total Usuarios</h5>
                            <h2 class="mb-0">{{ App\Models\User::count() }}</h2>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-people fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="col-md-3 mb-4">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="card-title">Ventas Hoy</h5>
                            <h2 class="mb-0">${{ number_format(App\Models\Sale::today()->sum('total_price'), 2) }}</h2>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-cart fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="col-md-3 mb-4">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="card-title">Stock Bajo</h5>
                            <h2 class="mb-0">{{ App\Models\Product::lowStock()->count() }}</h2>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-exclamation-triangle fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <!-- Productos con Stock Bajo -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Productos con Stock Bajo</h5>
                    <a href="{{ route('products.low-stock') }}" class="btn btn-sm btn-outline-primary">Ver Todos</a>
                </div>
                <div class="card-body">
                    @forelse(App\Models\Product::lowStock(5, 5) as $product)
                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                            <div>
                                <strong>{{ $product->name }}</strong>
                                <br>
                                <small class="text-muted">{{ $product->category }}</small>
                            </div>
                            <span class="badge bg-warning">{{ $product->stock }} unidades</span>
                        </div>
                    @empty
                        <p class="text-muted mb-0">No hay productos con stock bajo</p>
                    @endforelse
                </div>
            </div>
        </div>
    
        <!-- Ventas Recientes -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Ventas Recientes</h5>
                    <a href="#" class="btn btn-sm btn-outline-primary">Ver Todas</a>
                </div>
                <div class="card-body">
                    @forelse(App\Models\Sale::with(['product', 'user'])->orderBy('sale_date', 'desc')->limit(5)->get() as $sale)
                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                            <div>
                                <strong>{{ $sale->product->name ?? 'Producto eliminado' }}</strong>
                                <br>
                                <small class="text-muted">
                                    {{ $sale->user->full_name ?? 'Sin usuario' }} - 
                                    {{ $sale->sale_date->format('d/m/Y H:i') }}
                                </small>
                            </div>
                            <div class="text-end">
                                <div>{{ $sale->quantity }} x ${{ number_format($sale->product->price ?? 0, 2) }}</div>
                                <strong>${{ number_format($sale->total_price, 2) }}</strong>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted mb-0">No hay ventas registradas</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    
    <!-- Accesos Rápidos -->
    <div class="row">
        <div class="col-12">
            <h4 class="mb-3">Accesos Rápidos</h4>
        </div>
        
        <div class="col-md-2 mb-3">
            <a href="{{ route('products.create') }}" class="btn btn-outline-primary w-100 h-100 d-flex flex-column justify-content-center align-items-center py-4">
                <i class="bi bi-plus-circle fs-1 mb-2"></i>
                <span>Nuevo Producto</span>
            </a>
        </div>
        
        <div class="col-md-2 mb-3">
            <a href="{{ route('users.create') }}" class="btn btn-outline-success w-100 h-100 d-flex flex-column justify-content-center align-items-center py-4">
                <i class="bi bi-person-plus fs-1 mb-2"></i>
                <span>Nuevo Usuario</span>
            </a>
        </div>
        
        <div class="col-md-2 mb-3">
            <a href="#" class="btn btn-outline-info w-100 h-100 d-flex flex-column justify-content-center align-items-center py-4">
                <i class="bi bi-cart-plus fs-1 mb-2"></i>
                <span>Nueva Venta</span>
            </a>
        </div>
        
        <div class="col-md-2 mb-3">
            <a href="#" class="btn btn-outline-secondary w-100 h-100 d-flex flex-column justify-content-center align-items-center py-4">
                <i class="bi bi-list-ul fs-1 mb-2"></i>
                <span>Ver Productos</span>
            </a>
        </div>
        
        <div class="col-md-2 mb-3">
            <a href="{{ route('sales.reports') }}" class="btn btn-outline-warning w-100 h-100 d-flex flex-column justify-content-center align-items-center py-4">
                <i class="bi bi-graph-up fs-1 mb-2"></i>
                <span>Reportes</span>
            </a>
        </div>
        
        <div class="col-md-2 mb-3">
            <a href="{{ route('products.low-stock') }}" class="btn btn-outline-danger w-100 h-100 d-flex flex-column justify-content-center align-items-center py-4">
                <i class="bi bi-exclamation-triangle fs-1 mb-2"></i>
                <span>Stock Bajo</span>
            </a>
        </div>
    </div>
@else
    {{-- Si el usuario es vendedor, muestra una pantalla básica --}}
    <div class="row justify-content-center mt-5">
        <div class="col-md-8 text-center">
            <div class="card p-5 shadow-sm">
                <h1 class="display-4 mb-3">Bienvenido, Vendedor</h1>
                <p class="lead">Desde aquí podrás gestionar tus ventas y productos.</p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="#" class="btn btn-primary btn-lg mt-3">
                        <i class="bi bi-cart-plus me-2"></i>Registrar Nueva Venta
                    </a>
                    <a href="#" class="btn btn-secondary btn-lg mt-3">
                        <i class="bi bi-list-ul me-2"></i>Ver Productos
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Lista de ventas del vendedor --}}
    <div class="row mt-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Mis Ventas Recientes</h5>
                    <a href="#" class="btn btn-sm btn-outline-primary">Ver Todas Mis Ventas</a>
                </div>
                <div class="card-body">
                    @forelse(App\Models\Sale::where('user_id', auth()->user()->id)->latest()->limit(5)->get() as $sale)
                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                            <div>
                                <strong>{{ $sale->product->name ?? 'Producto eliminado' }}</strong>
                                <br>
                                <small class="text-muted">
                                    {{ $sale->user->full_name ?? 'Sin usuario' }} - 
                                    {{ $sale->sale_date->format('d/m/Y H:i') }}
                                </small>
                            </div>
                            <div class="text-end">
                                <div>{{ $sale->quantity }} x ${{ number_format($sale->product->price ?? 0, 2) }}</div>
                                <strong>${{ number_format($sale->total_price, 2) }}</strong>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted mb-0">No has registrado ventas aún.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endif
</x-app-layout>
