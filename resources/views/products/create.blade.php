<x-app-layout>
    <div class="container mx-auto p-4 bg-gray-100 min-h-screen">
        <div class="bg-white rounded-lg shadow-xl p-8 w-full max-w-md mx-auto">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Agregar Nuevo Producto</h2>
            <form id="product-form" action="{{ route('products.store') }}" method="POST">
                @csrf
                <!-- Campo de Nombre -->
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nombre</label>
                    <input type="text" id="name" name="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <!-- Campo de Descripción -->
                <div class="mb-4">
                    <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Descripción</label>
                    <input type="text" id="description" name="description" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <!-- Campo de Precio -->
                <div class="mb-4">
                    <label for="price" class="block text-gray-700 text-sm font-bold mb-2">Precio</label>
                    <input type="number" id="price" name="price" min="0" step="0.01" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <!-- Campo de Stock -->
                <div class="mb-4">
                    <label for="stock" class="block text-gray-700 text-sm font-bold mb-2">Stock</label>
                    <input type="number" id="stock" name="stock" min="0" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <!-- Campo de Categoría (Desplegable) -->
                <div class="mb-4">
                    <label for="category" class="block text-gray-700 text-sm font-bold mb-2">Categoría</label>
                    <select id="category" name="category" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        <option value="Soluble">Soluble</option>
                        <option value="Pildoras">Píldoras</option>
                        <option value="Jarabe">Jarabe</option>
                    </select>
                </div>
                <!-- Campo de Fecha de Vencimiento -->
                <div class="mb-4">
                    <label for="exp_date" class="block text-gray-700 text-sm font-bold mb-2">Fecha de Vencimiento</label>
                    <input type="date" id="exp_date" name="exp_date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                
                <div class="flex justify-end space-x-4">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md transition-colors duration-300">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
