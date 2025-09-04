<x-app-layout>
<div class="container mx-auto p-4 bg-gray-100 min-h-screen">

    <div class="flex justify-between items-center mb-4">
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                <p class="font-bold">¡Éxito!</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                <p class="font-bold">Error</p>
                <p>{{ session('error') }}</p>
            </div>
        @endif
        <h1 class="text-2xl font-bold text-gray-800">Lista de Productos</h1>
        @can('create products')
                <a href="{{ route('products.create') }}" class="mt-4 inline-block px-6 py-3 bg-blue-600 text-white rounded-lg">Crear Nuevo Producto</a>
        @endcan
    </div>
        {{-- Aviso para cuando no hay ventas --}}
        @if($products->isEmpty())
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4" role="alert">
                <p class="font-bold">Aviso</p>
                <p>No hay ninguna producto registrado en su base de datos.</p>
            </div>
        @endif

    <form action="{{ route('products.index') }}" method="GET">
        <div class="flex items-center space-x-4 mb-4">
            <div class="flex-grow">
                <input type="text" name="query" placeholder="Ingresa Nombre del medicamento" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>
            <button class="bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 px-4 rounded">Buscar</button>
        </div>
    </form>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full leading-normal">
            <thead>
                <tr class="bg-green-600 text-white uppercase text-sm font-semibold">
                    <th class="py-3 px-6 text-left">Folio</th>
                    <th class="py-3 px-6 text-left">Nombre</th>
                    <th class="py-3 px-6 text-left">Precio</th>
                    <th class="py-3 px-6 text-left">Stock</th>
                    <th class="py-3 px-6 text-left">Categoria</th>
                    <th class="py-3 px-6 text-left">Fecha de Vencimiento</th>
                    <th class="py-3 px-6 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @foreach($products as $product)
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6 text-left whitespace-nowrap">{{$product->id}}</td>
                    <td class="py-3 px-6 text-left">{{$product->name}}</td>
                    <td class="py-3 px-6 text-left">{{$product->price}}</td>
                    <td class="py-3 px-6 text-left">{{$product->stock}}</td>
                    <td class="py-3 px-6 text-left">{{$product->category}}</td>
                    <td class="py-3 px-6 text-left">{{$product->exp_date}}</td>
                    <td class="py-3 px-6 text-center">
                        <div class="flex item-center justify-center space-x-2">
                            {{--Botón ver--}}
                            <a href="{{ route('products.show', $product->id) }}" class="w-6 h-6 transform hover:scale-110 text-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                            <a>
                            {{--Botón de Modificar--}}
                            <a href="{{ route('products.edit', $product->id) }}" class="w-6 h-6 transform hover:scale-110 text-blue-500">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </a>
                            {{--Botón de Eliminar--}}
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                    class="w-6 h-6 transform hover:scale-110 text-red-500" 
                                    onclick="return confirm('¿Estás seguro de que deseas eliminar este producto?');">
                                    {{-- SVG Icon --}}
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div id="user-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden justify-center items-center">
        </div>
</div>
</x-app-layout>

<script>
    const addUserBtn = document.getElementById('add-user-btn');
    const userModal = document.getElementById('user-modal');

    if (addUserBtn) {
        addUserBtn.addEventListener('click', () => {
            userModal.classList.remove('hidden');
            userModal.classList.add('flex');
        });
    }

    function closeModal() {
        userModal.classList.remove('flex');
        userModal.classList.add('hidden');
    }

    function confirmDelete() {
        if (confirm('¿Estás seguro de que deseas eliminar este usuario?')) {
            console.log('Producto eliminado');
        }
    }
</script>