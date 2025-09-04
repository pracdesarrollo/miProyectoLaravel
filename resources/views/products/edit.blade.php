<x-app-layout>
    <div class="container mx-auto p-4 bg-gray-100 min-h-screen">
        <div class="bg-white rounded-lg shadow-xl p-8 w-full max-w-md mx-auto">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Editar Producto</h2>
            
            {{-- El formulario usa el método PUT para actualizar --}}
            <form action="{{ route('products.update', $product->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <!-- Campo de Nombre -->
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nombre</label>
                    <input type="text" id="name" name="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ $product->name }}" required>
                </div>
                <!-- Campo de Descripción -->
                <div class="mb-4">
                    <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Descripción</label>
                    <input type="text" id="description" name="description" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ $product->description }}" required>
                </div>
                <!-- Campo de Precio -->
                <div class="mb-4">
                    <label for="price" class="block text-gray-700 text-sm font-bold mb-2">Precio</label>
                    <input type="number" id="price" name="price" min="0" step="0.01" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ $product->price }}" required>
                </div>
                <!-- Campo de Stock -->
                <div class="mb-4">
                    <label for="stock" class="block text-gray-700 text-sm font-bold mb-2">Stock</label>
                    <input type="number" id="stock" name="stock" min="0" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ $product->stock }}" required>
                </div>
                <!-- Campo de Categoría (Desplegable) -->
                <div class="mb-6">
                    <label for="category" class="block text-gray-700 text-sm font-bold mb-2">Categoría</label>
                    <select id="category" name="category" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        <option value="Soluble" @if($product->category == 'Soluble') selected @endif>Soluble</option>
                        <option value="Pildoras" @if($product->category == 'Pildoras') selected @endif>Píldoras</option>
                        <option value="Jarabe" @if($product->category == 'Jarabe') selected @endif>Jarabe</option>
                    </select>
                </div>
                <!-- Campo de Fecha de Vencimiento -->
                <div class="mb-4">
                    <label for="expiration_date" class="block text-gray-700 text-sm font-bold mb-2">Fecha de Vencimiento</label>
                    <input type="date" id="expiration_date" name="expiration_date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ $product->expiration_date }}" required>
                </div>
                
                <div class="flex justify-end space-x-4">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md transition-colors duration-300">
                        Actualizar
                    </button>
                    <a href="{{ route('products.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-md transition-colors duration-300">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
