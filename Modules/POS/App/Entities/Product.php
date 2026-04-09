<?php

namespace Modules\POS\App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $table = 'pos_products';

    protected $fillable = [
        'category_id', 'name', 'slug', 'sku', 'description', 'image',
        'purchase_price', 'sale_price', 'stock', 'alert_quantity',
        'type', 'unit', 'barcode', 'is_active',
    ];

    protected $casts = [
        'purchase_price' => 'decimal:2',
        'sale_price'     => 'decimal:2',
        'stock'          => 'integer',
        'alert_quantity' => 'integer',
        'is_active'      => 'boolean',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
            if (empty($product->sku)) {
                $product->sku = strtoupper(Str::random(3)) . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
            }
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class, 'product_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeLowStock($query)
    {
        return $query->whereColumn('stock', '<=', 'alert_quantity');
    }

    public function getIsLowStockAttribute(): bool
    {
        return $this->stock <= $this->alert_quantity;
    }

    public static function searchByNameOrSku(string $search)
    {
        return static::where('is_active', true)
            ->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('barcode', $search);
            });
    }
}
