{{-- resources/views/products/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Productos</h1>
    <a href="{{ route('products.create') }}" class="btn btn-primary">
        <i class="bi bi-plus"></i> Nuevo Producto
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Categoría</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Fecha Vencimiento</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category }}</td>
                        <td>${{ number_format($product->price, 2) }}</td>
                        <td>
                            <span class="badge {{ $product->stock < 10 ? 'bg-warning' : 'bg-success' }}">
                                {{ $product->stock }}
                            </span>
                        </td>
                        <td>
                            @if($product->exp_date)
                                {{ $product->exp_date->format('d/m/Y') }}
                                @if($product->is_expired)
                                    <span class="badge bg-danger ms-1">Vencido</span>
                                @elseif($product->is_expiring)
                                    <span class="badge bg-warning ms-1">Próximo a vencer</span>
                                @endif
                            @else
                                <span class="text-muted">Sin fecha</span>
                            @endif
                        </td>
                    
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-outline-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" 
                                            onclick="return confirm('¿Estás seguro?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">No hay productos registrados</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{ $products->links() }}
    </div>
</div>
@endsection

