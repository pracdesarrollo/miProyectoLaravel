<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'name', 'price', 'stock', 'description', 'category', 'exp_date'
    ];
     /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'exp_date' => 'datetime', // <-- Add this line
    ];



    /**
     * Devuelve productos con stock bajo
     * @param int $threshold Cantidad mínima para considerar bajo stock
     * @param int|null $limit Limite de productos a devolver
     */
    public static function lowStock($threshold = 5, $limit = null)
    {
        $query = self::where('stock', '<=', $threshold);

        if ($limit) {
            $query->limit($limit); // ✅ limit en query builder
        }

        return $query->get(); // devuelve Collection
    }
     public function scopeAvailable($query)
    {
        return $query->where('stock', '>', 0);
    }
    public function sales()
    {
        return $this->belongsToMany(Sale::class, 'sale_products')
                    ->withPivot('quantity', 'price_at_sale')
                    ->withTimestamps();
    }
}
