<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Crear Venta</title>
</head>
<body>
    <h1>Registrar Nueva Venta</h1>

    <form action="{{ route('sales.store') }}" method="POST">
        @csrf

        <div>
            <label for="product_id">Producto:</label>
            <select name="product_id" id="product_id" required>
                <option value="">Selecciona un producto</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }} ({{ $product->price }} $)</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="user_id">Usuario (Opcional):</label>
            <select name="user_id" id="user_id">
                <option value="">Selecciona un usuario</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="quantity">Cantidad:</label>
            <input type="number" id="quantity" name="quantity" required min="1">
        </div>

        <div>
            <label for="sale_date">Fecha de Venta:</label>
            <input type="date" id="sale_date" name="sale_date" required>
        </div>

        <button type="submit">Registrar Venta</button>
    </form>
</body>
</html>