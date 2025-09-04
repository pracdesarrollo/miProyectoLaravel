<?php

namespace App\Models;

use App\Models\Product; 
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'sale_date',
        'total_price',
    ];

    protected $casts = [
        'sale_date' => 'datetime',
        'total_price' => 'decimal:2',
    ];

    // Relación con producto
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'sale_product')
                    ->withPivot('quantity', 'price_at_sale')
                    ->withTimestamps();
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
}
