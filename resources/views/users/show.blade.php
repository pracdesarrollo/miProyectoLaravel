<x-app-layout>
    <div class="container mx-auto p-4 bg-gray-100 min-h-screen">
        <div class="bg-white rounded-lg shadow-xl p-8 w-full max-w-md mx-auto">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Detalles del Usuario</h2>
            
            <div class="mb-4">
                <p class="font-bold text-gray-700">Nombre:</p>
                <p class="text-gray-900">{{ $user->name }}</p>
            </div>
            <div class="mb-4">
                <p class="font-bold text-gray-700">Apellido:</p>
                <p class="text-gray-900">{{ $user->last_name }}</p>
            </div>
            <div class="mb-4">
                <p class="font-bold text-gray-700">Correo:</p>
                <p class="text-gray-900">{{ $user->email }}</p>
            </div>
            <div class="mb-4">
                <p class="text-gray-900">{{ $user->getRoleNames()->first() }}</p>
                <p class="text-gray-900">{{ $user->role }}</p>
            </div>

            <a href="{{ route('users.index') }}" class="mt-4 inline-block px-4 py-2 bg-gray-300 text-gray-800 rounded-md">Regresar</a>
        </div>
    </div>
</x-app-layout>