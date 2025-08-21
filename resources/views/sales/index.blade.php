{{-- resources/views/users/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Usuarios</h1>
    <a href="{{ route('users.create') }}" class="btn btn-primary">
        <i class="bi bi-plus"></i> Nuevo Usuario
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
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Total Compras</th>
                        <th>Fecha Registro</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->full_name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone ?? 'No especificado' }}</td>
                        <td>
                            @php
                                $totalPurchases = $user->sales->sum('total_price');
                                $purchaseCount = $user->sales->count();
                            @endphp
                            <div>${{ number_format($totalPurchases, 2) }}</div>
                            <small class="text-muted">{{ $purchaseCount }} compras</small>
                        </td>
                        <td>{{ $user->created_at->format('d/m/Y') }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('users.show', $user) }}" class="btn btn-sm btn-outline-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline">
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
                        <td colspan="7" class="text-center">No hay usuarios registrados</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{ $users->links() }}
    </div>
</div>
@endsection

{{-- resources/views/users/create.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Crear Nuevo Usuario</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nombre *</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="last_name" class="form-label">Apellido *</label>
                                <input type="text" class="form-control @error('last_name') is-invalid @enderror" 
                                       id="last_name" name="last_name" value="{{ old('last_name') }}" required>
                                @error('last_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email *</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Teléfono</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                               id="phone" name="phone" value="{{ old('phone') }}">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña *</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="password" name="password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirmar Contraseña *</label>
                        <input type="password" class="form-control" 
                               id="password_confirmation" name="password_confirmation" required>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Guardar Usuario</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- resources/views/users/edit.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Editar Usuario: {{ $user->full_name }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('users.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nombre *</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="last_name" class="form-label">Apellido *</label>
                                <input type="text" class="form-control @error('last_name') is-invalid @enderror" 
                                       id="last_name" name="last_name" value="{{ old('last_name', $user->last_name) }}" required>
                                @error('last_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email *</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Teléfono</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                               id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> 
                        La contraseña no se modificará a menos que especifiques una nueva.
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- resources/views/users/show.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Perfil de Usuario: {{ $user->full_name }}</h5>
                <div>
                    <a href="{{ route('users.edit', $user) }}" class="btn btn-primary">
                        <i class="bi bi-pencil"></i> Editar
                    </a>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Volver
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Información Personal</h6>
                        <table class="table table-sm">
                            <tr>
                                <th>Nombre completo:</th>
                                <td>{{ $user->full_name }}</td>
                            </tr>
                            <tr>
                                <th>Email:</th>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <th>Teléfono:</th>
                                <td>{{ $user->phone ?? 'No especificado' }}</td>
                            </tr>
                            <tr>
                                <th>Fecha de registro:</th>
                                <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6>Estadísticas de Compras</h6>
                        @php
                            $totalPurchases = $user->sales->sum('total_price');
                            $purchaseCount = $user->sales->count();
                            $avgPurchase = $purchaseCount > 0 ? $totalPurchases / $purchaseCount : 0;
                            $lastPurchase = $user->sales()->latest('sale_date')->first();
                        @endphp
                        
                        <div class="row text-center">
                            <div class="col-6">
                                <div class="card bg-primary text-white">
                                    <div class="card-body">
                                        <h4>${{ number_format($totalPurchases, 2) }}</h4>
                                        <small>Total Gastado</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card bg-success text-white">
                                    <div class="card-body">
                                        <h4>{{ $purchaseCount }}</h4>
                                        <small>Compras Realizadas</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <table class="table table-sm mt-3">
                            <tr>
                                <th>Compra promedio:</th>
                                <td>${{ number_format($avgPurchase, 2) }}</td>
                            </tr>
                            <tr>
                                <th>Última compra:</th>
                                <td>
                                    @if($lastPurchase)
                                        {{ $lastPurchase->sale_date->format('d/m/Y') }}
                                    @else
                                        Sin compras
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <hr>

                <h6>Historial de Compras</h6>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio Unitario</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($user->sales()->with('product')->latest('sale_date')->limit(10)->get() as $sale)
                            <tr>
                                <td>{{ $sale->sale_date->format('d/m/Y H:i') }}</td>
                                <td>{{ $sale->product->name ?? 'Producto eliminado' }}</td>
                                <td>{{ $sale->quantity }}</td>
                                <td>
                                    @if($sale->product)
                                        ${{ number_format($sale->product->price, 2) }}
                                    @else
                                        ${{ number_format($sale->total_price / $sale->quantity, 2) }}
                                    @endif
                                </td>
                                <td>${{ number_format($sale->total_price, 2) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">No hay compras registradas</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($user->sales()->count() > 10)
                    <div class="text-center">
                        <small class="text-muted">Mostrando las últimas 10 compras de {{ $user->sales()->count() }} totales</small>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection