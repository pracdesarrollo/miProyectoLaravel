@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Detalles del Producto</h1>
            <hr>
            <div>
                <strong>ID:</strong> {{ $product->id }}
            </div>
            <div>
                <strong>Nombre:</strong> {{ $product->name }}
            </div>
            <div>
                <strong>Descripción:</strong> {{ $product->description }}
            </div>
            <div>
                <strong>Precio:</strong> ${{ number_format($product->price, 2) }}
            </div>
            <div>
                <strong>Stock:</strong> {{ $product->stock }}
            </div>
            <div>
                <strong>Categoría:</strong> {{ $product->category }}
            </div>
            <div>
                <strong>Fecha de Vencimiento:</strong> 
                @if($product->exp_date)
                    {{ $product->exp_date->format('d/m/Y') }}
                @else
                    Sin fecha
                @endif
            </div>
            <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">Volver a la lista</a>
        </div>
    </div>
</div>
@endsection