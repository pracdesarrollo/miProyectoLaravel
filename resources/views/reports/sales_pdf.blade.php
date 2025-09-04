<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Ventas</title>
</head>
<body style="font-family: Arial, sans-serif; font-size: 12px; margin: 0; padding: 20px; color: #333;">
    <div style="text-align: center; margin-bottom: 20px;">
        <h1 style="font-size: 20px; margin: 0;">Reporte de Ventas</h1>
        <p style="font-size: 14px; color: #555; margin-top: 5px;">{{ $startDate }} al {{ $endDate }}</p>
    </div>

    @if(empty($sales))
        <p>No se encontraron ventas en el rango de fechas seleccionado.</p>
    @else
        <table style="width: 100%; border-collapse: collapse; margin-top: 20px; table-layout: fixed;">
            <thead>
                <tr style="background-color: #f2f2f2;">
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left; font-size: 10px; font-weight: bold;">Fecha</th>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left; font-size: 10px; font-weight: bold;">Producto</th>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left; font-size: 10px; font-weight: bold;">Cantidad</th>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left; font-size: 10px; font-weight: bold;">Precio Unitario</th>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left; font-size: 10px; font-weight: bold;">Total de Venta</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sales as $item)
                <tr>
                    <td style="border: 1px solid #ddd; padding: 8px; font-size: 10px;">{{ $item['sale_date'] }}</td>
                    <td style="border: 1px solid #ddd; padding: 8px; font-size: 10px;">{{ $item['product_name'] }}</td>
                    <td style="border: 1px solid #ddd; padding: 8px; font-size: 10px;">{{ $item['quantity'] }}</td>
                    <td style="border: 1px solid #ddd; padding: 8px; font-size: 10px;">{{ $item['unit_price'] }}</td>
                    <td style="border: 1px solid #ddd; padding: 8px; font-size: 10px;">{{ $item['total_price'] }}</td>
                </tr>
                @endforeach
                <tr style="font-weight: bold;">
                    <td colspan="4" style="border: 1px solid #ddd; padding: 8px; text-align: right; background-color: #f9f9f9;">Total del Reporte:</td>
                    <td style="border: 1px solid #ddd; padding: 8px; background-color: #f9f9f9;">{{ $totalSales }}</td>
                </tr>
            </tbody>
        </table>
    @endif
</body>
</html>
