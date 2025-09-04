<x-app-layout>
    <div class="container mx-auto p-4 bg-gray-100 min-h-screen">
        <div class="bg-white rounded-lg shadow-xl p-8 w-full max-w-md mx-auto">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Detalles del Producto</h2>
            
            <div class="mb-4">
                <p class="font-bold text-gray-700">Folio:</p>
                <p class="text-gray-900">{{ $product->id }}</p>
            </div>
            <div class="mb-4">
                <p class="font-bold text-gray-700">Nombre:</p>
                <p class="text-gray-900">{{ $product->name }}</p>
            </div>
            <div class="mb-4">
                <p class="font-bold text-gray-700">Descripción:</p>
                <p class="text-gray-900">{{ $product->description}}</p>
            </div>
            <div class="mb-4">
                <p class="font-bold text-gray-700">Precio:</p>
                <p class="text-gray-900">{{ $product->price}}</p>
            </div>
            <div class="mb-4">
                <p class="font-bold text-gray-700">Stock:</p>
                <p class="text-gray-900">{{ $product->stock}}</p>
            </div>
            <div class="mb-4">
                <p class="font-bold text-gray-700">Categoria:</p>
                <p class="text-gray-900 break-all">{{ $product->category }}</p>
            </div>
            <div class="mb-4">
                <p class="font-bold text-gray-700">Fecha de Vencimiento</p>
                <p class="text-gray-900">{{ $product->exp_date}}</p>
            </div>

            <a href="{{ route('products.index') }}" class="mt-4 inline-block px-4 py-2 bg-gray-300 text-gray-800 rounded-md">Regresar</a>
        </div>
    </div>
</x-app-layout>