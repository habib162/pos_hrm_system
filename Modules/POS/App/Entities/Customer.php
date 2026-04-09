<?php

namespace Modules\POS\App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    protected $table = 'pos_customers';

    protected $fillable = [
        'name', 'email', 'phone', 'address',
        'points', 'credit_limit', 'balance',
    ];

    protected $casts = [
        'points'       => 'integer',
        'credit_limit' => 'decimal:2',
        'balance'      => 'decimal:2',
    ];

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class, 'customer_id');
    }

    public function addPoints(float $amount): void
    {
        $this->increment('points', (int) floor($amount / 100));
    }
}
