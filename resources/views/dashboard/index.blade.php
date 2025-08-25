<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema de Ventas - Inicio</title>

    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
</head>
<body>

<nav class="bg-white border-b border-gray-200 shadow-sm py-4">
    <div class="container mx-auto px-4 flex justify-between items-center">
        <a class="flex items-center text-lg font-bold text-gray-800" href="/">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615A2.993 2.993 0 0 0 9.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 0 0 2.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 0 0 3.75.614m-16.5 0a3.004 3.004 0 0 1-.621-4.72l1.189-1.19A1.5 1.5 0 0 1 5.378 3h13.243a1.5 1.5 0 0 1 1.06.44l1.19 1.189a3 3 0 0 1-.621 4.72M6.75 18h3.75a.75.75 0 0 0 .75-.75V13.5a.75.75 0 0 0-.75-.75H6.75a.75.75 0 0 0-.75.75v3.75c0 .414.336.75.75.75Z" />
            </svg>

            Sistema de Ventas
        </a>
        <div class="flex items-center space-x-4">
            <a class="text-gray-600 hover:text-blue-600" href="{{ route('login') }}">Login</a>
            <a class="text-gray-600 hover:text-blue-600" href="{{ route('register') }}">Registro</a>
        </div>
    </div>
</nav>

<header class="bg-blue-600 text-white py-32 text-center">
    <div class="container mx-auto px-4">
        <h1 class="text-5xl font-extrabold">Gestión de Ventas Simplificada</h1>
        <p class="text-xl mt-3 mb-8">
            Optimiza tu negocio y lleva un control total de tus productos, inventario y ventas.
        </p>
        <a href="{{ route('login') }}" class="bg-white text-blue-600 font-bold py-3 px-8 rounded-lg shadow-md transition-all duration-300 hover:bg-gray-100">
            Comenzar Ahora
        </a>
    </div>
</header>

<section class="bg-white py-16">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-extrabold text-gray-800">¿Qué hace nuestra aplicación?</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-6 rounded-lg shadow text-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 7.5-9-5.25L3 7.5m18 0-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                </svg>

                <h5 class="font-bold text-xl mb-2 text-gray-800">Gestión de Productos</h5>
                <p class="text-gray-600">
                    Controla tu inventario, precios y stock en tiempo real.
                </p>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow text-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                </svg>

                <h5 class="font-bold text-xl mb-2 text-gray-800">Registro de Ventas</h5>
                <p class="text-gray-600">
                    Registra cada transacción de forma rápida y sencilla.
                </p>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow text-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                </svg>

                <h5 class="font-bold text-xl mb-2 text-gray-800">Control de Usuarios</h5>
                <p class="text-gray-600">
                    Gestiona los accesos de administradores y vendedores de tu equipo.
                </p>
            </div>
        </div>
    </div>
</section>

<footer class="bg-gray-100 py-8 text-center">
    <div class="container mx-auto px-4">
        <p class="text-gray-500 text-sm">&copy; {{ date('Y') }} Sistema de Ventas. Todos los derechos reservados.</p>
    </div>
</footer>

</body>
</html>