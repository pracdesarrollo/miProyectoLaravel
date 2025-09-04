<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Sale;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function generateApi(Request $request)
    {
        // 1. Validate that the dates are present
        if (!$request->input('start_date') || !$request->input('end_date')) {
            return response()->json([
                'status' => 'error',
                'message' => 'Por favor, selecciona un rango de fechas.'
            ], 400);
        }

        try {
            // 2. Adjust date range to include the entire day
            $startDate = Carbon::parse($request->input('start_date'))->startOfDay();
            $endDate = Carbon::parse($request->input('end_date'))->endOfDay();

            // 3. Get sales with their related products using the pivot table
            $sales = Sale::with('products')
                ->whereBetween('sale_date', [$startDate, $endDate])
                ->get();

            // 4. Transform the data into a flat structure for the front end
            $salesData = [];
            foreach ($sales as $sale) {
                foreach ($sale->products as $product) {
                    $salesData[] = [
                        'sale_date' => Carbon::parse($sale->sale_date)->format('Y-m-d'),
                        'product_name' => $product->name,
                        'quantity' => $product->pivot->quantity,
                        'unit_price' => number_format($product->pivot->price_at_sale, 2),
                        'total_price' => number_format($product->pivot->quantity * $product->pivot->price_at_sale, 2),
                    ];
                }
            }

            return response()->json([
                'status' => 'success',
                'sales' => $salesData,
                'startDate' => $startDate->format('Y-m-d'),
                'endDate' => $endDate->format('Y-m-d'),
            ]);

        } catch (\Exception $e) {
            // 5. Capture any exceptions to prevent generic errors
            return response()->json([
                'status' => 'error',
                'message' => 'Hubo un error al procesar el reporte: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function generatePdf(Request $request)
    {
        $startDate = Carbon::parse($request->input('start_date'))->startOfDay();
        $endDate = Carbon::parse($request->input('end_date'))->endOfDay();

        if (!$request->input('start_date') || !$request->input('end_date')) {
            abort(400, 'Faltan las fechas de inicio o fin.');
        }

        // 1. Obtén las ventas y sus productos relacionados.
        $sales = Sale::with('products')
            ->whereBetween('sale_date', [$startDate, $endDate])
            ->get();

        // 2. Transforma los datos en una estructura plana (un array de productos).
        $salesData = [];
        $totalReportSales = 0;

        foreach ($sales as $sale) {
            foreach ($sale->products as $product) {
                $totalProductPrice = $product->pivot->quantity * $product->pivot->price_at_sale;
                $salesData[] = [
                    'sale_date' => Carbon::parse($sale->sale_date)->format('Y-m-d'),
                    'product_name' => $product->name,
                    'quantity' => $product->pivot->quantity,
                    'unit_price' => number_format($product->pivot->price_at_sale, 2),
                    'total_price' => number_format($totalProductPrice, 2),
                ];
                $totalReportSales += $totalProductPrice;
            }
        }

        // 3. Prepara los datos para la vista del PDF.
        $data = [
            'sales' => $salesData, 
            'startDate' => $startDate->format('Y-m-d'),
            'endDate' => $endDate->format('Y-m-d'),
            'totalSales' => number_format($totalReportSales, 2),
        ];

        $pdf = Pdf::loadView('reports.sales_pdf', $data);

        return $pdf->download('reporte_de_ventas_' . $startDate->format('Y-m-d') . '_' . $endDate->format('Y-m-d') . '.pdf');
    }
}
