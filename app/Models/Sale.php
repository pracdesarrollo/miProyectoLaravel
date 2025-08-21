<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'quantity',
        'sale_date',
        'total_price',
    ];

    protected $casts = [
        'sale_date' => 'datetime',
        'total_price' => 'decimal:2',
        'quantity' => 'integer',
    ];

    // Relación con producto
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relación con usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scope para ventas de hoy
    public function scopeToday($query)
    {
        return $query->whereDate('sale_date', now()->toDateString());
    }

    // Scope para ventas de un mes específico
    public function scopeByMonth($query, $month, $year = null)
    {
        $year = $year ?? now()->year;
        return $query->whereMonth('sale_date', $month)
                    ->whereYear('sale_date', $year);
    }

    // Scope para ventas entre fechas
    public function scopeBetweenDates($query, $startDate, $endDate)
    {
        return $query->whereBetween('sale_date', [$startDate, $endDate]);
    }

    // Método estático para calcular total de ventas
    public static function totalSales($startDate = null, $endDate = null)
    {
        $query = self::query();
        
        if ($startDate && $endDate) {
            $query->betweenDates($startDate, $endDate);
        }
        
        return $query->sum('total_price');
    }

    // Evento para calcular precio total automáticamente
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($sale) {
            if (!$sale->total_price && $sale->product) {
                $sale->total_price = $sale->product->price * $sale->quantity;
            }
        });
    }
}